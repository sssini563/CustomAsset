<?php

namespace App\Http\Controllers\Documents;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class DocumentMetaDefaultsController extends Controller
{
    public function edit()
    {
        $setting = Setting::getSettings();
        // Split Asset into two categories: form (Serah Terima) and sp (Surat Pernyataan)
        $types = ['asset_form','asset_sp','component','license','accessory','consumable'];
        $defaults = [];
        foreach ($types as $t) {
            $key = 'document_defaults_'.$t;
            $defaults[$t] = is_array($setting->{$key} ?? null) ? $setting->{$key} : [];
        }
        // Back-compat: hydrate global defaults if per-type empty
        $global = [
            'jenis_dokumen' => $setting->document_default_jenis_dokumen,
            'sp_hal' => $setting->document_default_sp_hal,
            'pemilik_proses' => $setting->document_default_pemilik_proses,
            'proses_bisnis' => $setting->document_default_proses_bisnis,
        ];
        foreach ($types as $t) {
            $defaults[$t] = array_merge($global, $defaults[$t]);
        }
    return view('documents.meta_defaults.edit', compact('setting','types','defaults'));
    }

    public function update(Request $request)
    {
        $types = ['asset_form','asset_sp','component','license','accessory','consumable'];
        $data = [];
        foreach ($types as $t) {
            $data['document_defaults_'.$t] = [
                'jenis_dokumen' => $request->input($t.'.jenis_dokumen'),
                'sp_hal' => $request->input($t.'.sp_hal'),
                'pemilik_proses' => $request->input($t.'.pemilik_proses'),
                'proses_bisnis' => $request->input($t.'.proses_bisnis'),
                'doc_control_no' => $request->input($t.'.doc_control_no'),
                'effective_doc' => $request->input($t.'.effective_doc'),
                'revision_date' => $request->input($t.'.revision_date'),
                'author_doc' => $request->input($t.'.author_doc'),
            ];
        }
        $setting = Setting::getSettings();
        foreach ($data as $k=>$v) { $setting->{$k} = $v; }
        $setting->save();
        return redirect()->route('documents.meta.defaults.edit')->with('success','Document metadata defaults saved');
    }
}

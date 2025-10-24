<!-- Modal -->
<div class="modal fade" id="uploadFileModal" tabindex="-1" role="dialog" aria-labelledby="uploadFileModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="uploadFileModalLabel"><?php echo e(trans('general.file_upload')); ?></h4>
            </div>
            <form
                method="POST"
                action="<?php echo e(route('ui.files.store', ['object_type' => str_plural($item_type), 'id' => $item_id])); ?>"
                accept-charset="UTF-8"
                class="form-horizontal"
                enctype="multipart/form-data"
            >
            <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>" />
            <div class="modal-body">

                <div class="row">
                    <div class="col-md-12">

                        <label class="btn btn-default btn-block">
                            <?php echo e(trans('button.select_files')); ?>

                            <input type="file" name="file[]" multiple class="js-uploadFile" id="uploadFile" data-maxsize="<?php echo e(Helper::file_upload_max_size()); ?>" accept="<?php echo e(config('filesystems.allowed_upload_mimetypes')); ?>" style="display:none" required>
                        </label>

                    </div>
                    <div class="col-md-12">
                        <span id="uploadFile-info"></span>
                    </div>
                    <div class="col-md-12">
                        <p class="help-block" id="uploadFile-status"><?php echo e(trans('general.upload_filetypes_help', ['allowed_filetypes' => config('filesystems.allowed_upload_extensions'), 'size' => Helper::file_upload_max_size_readable()])); ?></p>
                    </div>

                    <div class="col-md-12">
                        <?php if (isset($component)) { $__componentOriginal9ff136736d107222a7c2416559088828 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ff136736d107222a7c2416559088828 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => '53a84532857250ffb7b99fa272c3af08::input.textarea','data' => ['name' => 'notes','value' => old('notes'),'placeholder' => 'Notes (Optional)','rows' => '3','ariaLabel' => 'file']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input.textarea'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'notes','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('notes')),'placeholder' => 'Notes (Optional)','rows' => '3','aria-label' => 'file']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ff136736d107222a7c2416559088828)): ?>
<?php $attributes = $__attributesOriginal9ff136736d107222a7c2416559088828; ?>
<?php unset($__attributesOriginal9ff136736d107222a7c2416559088828); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ff136736d107222a7c2416559088828)): ?>
<?php $component = $__componentOriginal9ff136736d107222a7c2416559088828; ?>
<?php unset($__componentOriginal9ff136736d107222a7c2416559088828); ?>
<?php endif; ?>
                    </div>
                </div>

            </div> <!-- /.modal-body-->
            <div class="modal-footer">
                <a href="#" class="pull-left" data-dismiss="modal"><?php echo e(trans('button.cancel')); ?></a>
                <button type="submit" class="btn btn-primary"><?php echo e(trans('button.upload')); ?></button>
            </div>
            </form>
        </div>
    </div>
</div>
<?php /**PATH C:\laravel\backup\snipe-it-8.3.3 - Copy\resources\views/modals/upload-file.blade.php ENDPATH**/ ?>
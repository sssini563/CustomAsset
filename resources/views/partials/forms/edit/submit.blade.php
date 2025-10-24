<!-- partials/forms/edit/submit.blade.php -->

<div class="box-footer"
    style="padding-bottom: 0px; overflow: hidden; display: flex; justify-content: space-between; align-items: center;">
    <a class="btn btn-link" href="{{ URL::previous() }}" style="float: left;">{{ trans('button.cancel') }}</a>
    <button type="submit" {{ $snipeSettings->shortcuts_enabled == 1 ? 'accesskey=s' : '' }} class="btn btn-primary"
        style="float: right;"><x-icon type="checkmark" /> {{ trans('general.save') }}</button>
</div>
<!-- / partials/forms/edit/submit.blade.php -->

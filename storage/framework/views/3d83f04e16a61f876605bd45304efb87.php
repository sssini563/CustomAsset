
<div class="modal fade" id="createNoteModal" tabindex="-1" role="dialog" aria-labelledby="createNoteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h2 class="modal-title" id="createNoteModalLabel"><?php echo e(trans('general.add_note')); ?></h2>
            </div>
            <form
                method="POST"
                action="<?php echo e(route('notes.store')); ?>"
                accept-charset="UTF-8"
            >
                <?php echo csrf_field(); ?>
                <input type="hidden" name="type" value="<?php echo e($type); ?>"/>
                <input type="hidden" name="id" value="<?php echo e($id); ?>"/>

                <div class="modal-body">
                    <div class="alert alert-danger" id="modal_error_msg" style="display:none"></div>

                    <div class="row">
                        <div class="col-md-12">
                            <textarea class="form-control" id="note" name="note" required><?php echo e(old('note')); ?></textarea>
                            <?php echo $errors->first('note', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>'); ?>

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal"><?php echo e(trans('button.cancel')); ?></button>
                    <button type="submit" class="btn btn-primary pull-right" id="modal-save"><?php echo e(trans('general.save')); ?></button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<?php /**PATH C:\laravel\backup\snipe-it-8.3.3 - Copy\resources\views/modals/add-note.blade.php ENDPATH**/ ?>
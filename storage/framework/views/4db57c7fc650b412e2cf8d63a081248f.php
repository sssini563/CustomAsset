<?php $__env->startSection('title'); ?>

 <?php echo e(trans('general.location')); ?>:
 <?php echo e($location->name); ?>

 
<?php echo \Illuminate\View\Factory::parentPlaceholder('title'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('header_right'); ?>
<a href="<?php echo e(route('locations.index')); ?>" class="btn btn-primary" style="margin-right: 10px;">
    <?php echo e(trans('general.back')); ?></a>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<div class="row">

    <?php if($location->deleted_at!=''): ?>
        <div class="col-md-12">
            <div class="callout callout-warning">
                <?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => '53a84532857250ffb7b99fa272c3af08::icon','data' => ['type' => 'warning']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'warning']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $attributes = $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $component = $__componentOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
                <?php echo e(trans('admin/locations/message.deleted_warning')); ?>

            </div>
        </div>
    <?php endif; ?>


  <div class="col-md-9">



      <div class="nav-tabs-custom">
          <ul class="nav nav-tabs hidden-print">

              <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view', \App\Models\User::class)): ?>
                      <li class="active">
                          <a href="#users" data-toggle="tab">
                              <i class="fa-solid fa-house-user fa-fw" style="font-size: 17px" aria-hidden="true"></i>
                              <span class="sr-only">
                            <?php echo e(trans('general.users')); ?>

                              </span>
                              <?php echo ($location->users()->count() > 0) ? '<span class="badge">'.number_format($location->users()->count()).'</span>' : ''; ?>

                          </a>
                      </li>
              <?php endif; ?>

              <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view', \App\Models\Asset::class)): ?>
                      <li>
                          <a href="#assets" data-toggle="tab" data-tooltip="true" title="<?php echo e(trans('admin/locations/message.current_location')); ?>">
                              <i class="fa-solid fa-house-laptop fa-fw" style="font-size: 17px" aria-hidden="true"></i>
                              <?php echo ($location->assets()->AssetsForShow()->count() > 0) ? '<span class="badge">'.number_format($location->assets()->AssetsForShow()->count()).'</span>' : ''; ?>

                              <span class="sr-only">
                          <?php echo e(trans('admin/locations/message.current_location')); ?>

                      </span>
                          </a>
                      </li>

                      <li>
                          <a href="#rtd_assets" data-toggle="tab" data-tooltip="true" title="<?php echo e(trans('admin/hardware/form.default_location')); ?>">
                              <i class="fa-solid fa-house-flag fa-fw" style="font-size: 17px" aria-hidden="true"></i>
                              <?php echo ($location->rtd_assets()->AssetsForShow()->count() > 0) ? '<span class="badge">'.number_format($location->rtd_assets()->AssetsForShow()->count()).'</span>' : ''; ?>

                              <span class="sr-only">
                          <?php echo e(trans('admin/hardware/form.default_location')); ?>

                      </span>
                          </a>
                      </li>

                      <li>
                          <a href="#assets_assigned" data-toggle="tab" data-tooltip="true" title="<?php echo e(trans('admin/locations/message.assigned_assets')); ?>">
                              <i class="fas fa-barcode fa-fw" style="font-size: 17px" aria-hidden="true"></i>
                              <?php echo ($location->assignedAssets()->AssetsForShow()->count() > 0) ? '<span class="badge">'.number_format($location->assignedAssets()->AssetsForShow()->count()).'</span>' : ''; ?>

                              <span class="sr-only">
                          <?php echo e(trans('admin/locations/message.assigned_assets')); ?>

                      </span>
                          </a>
                      </li>
              <?php endif; ?>

                  <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view', \App\Models\Accessory::class)): ?>
                          <li>
                              <a href="#accessories" data-toggle="tab" data-tooltip="true" title="<?php echo e(trans('general.accessories')); ?>">
                                  <i class="far fa-keyboard fa-fw" style="font-size: 17px" aria-hidden="true"></i>
                                  <?php echo ($location->accessories()->count() > 0) ? '<span class="badge">'.number_format($location->accessories()->count()).'</span>' : ''; ?>

                                  <span class="sr-only">
                                    <?php echo e(trans('general.accessories')); ?>

                                  </span>
                              </a>
                          </li>

                          <li>
                              <a href="#accessories_assigned" data-toggle="tab" data-tooltip="true" title="<?php echo e(trans('general.accessories_assigned')); ?>">
                                  <i class="fas fa-keyboard fa-fw" style="font-size: 17px" aria-hidden="true"></i>
                                  <?php echo ($location->assignedAccessories()->count() > 0) ? '<span class="badge">'.number_format($location->assignedAccessories()->count()).'</span>' : ''; ?>

                                  <span class="sr-only">
                                      <?php echo e(trans('general.accessories_assigned')); ?>

                                  </span>
                              </a>
                          </li>
                  <?php endif; ?>


              <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view', \App\Models\Consumable::class)): ?>
                          <li>
                              <a href="#consumables" data-toggle="tab" data-tooltip="true" title="<?php echo e(trans('general.consumables')); ?>">
                                  <i class="fas fa-tint fa-fw" style="font-size: 17px" aria-hidden="true"></i>
                                  <?php echo ($location->consumables()->count() > 0) ? '<span class="badge">'.number_format($location->consumables->count()).'</span>' : ''; ?>

                                  <span class="sr-only">
                              <?php echo e(trans('general.consumables')); ?>

                          </span>
                              </a>
                          </li>
                  <?php endif; ?>

                  <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view', \App\Models\Component::class)): ?>
                          <li>
                              <a href="#components" data-toggle="tab" data-tooltip="true" title="<?php echo e(trans('general.components')); ?>">
                                  <i class="fas fa-hdd fa-fw" style="font-size: 17px" aria-hidden="true"></i>
                                  <?php echo ($location->components->count() > 0) ? '<span class="badge">'.number_format($location->components()->count()).'</span>' : ''; ?>

                                  <span class="sr-only">
                                    <?php echo e(trans('general.components')); ?>

                                  </span>
                              </a>
                          </li>
                  <?php endif; ?>

                  <li>
                      <a href="#child_locations" data-toggle="tab" data-tooltip="true" title="<?php echo e(trans('general.child_locations')); ?>">
                          <span class="hidden-xs hidden-sm">
                               <i class="fa-solid fa-city fa-fw" style="font-size: 17px" aria-hidden="true"></i>
                          <span class="sr-only">
                            <?php echo e(trans('general.child_locations')); ?>

                          </span>
                          <?php echo ($location->children()->count() > 0 ) ? '<span class="badge">'.number_format($location->children()->count()).'</span>' : ''; ?>

                      </span>
                      </a>
                  </li>

              <li>
                  <a href="#files" data-toggle="tab" data-tooltip="true" title="<?php echo e(trans('general.files')); ?>">

                    <span class="hidden-lg hidden-md">
                      <i class="fas fa-barcode fa-2x"></i>
                    </span>
                      <span class="hidden-xs hidden-sm">
                          <i class="fa-solid fa-file-contract fa-fw" style="font-size: 17px" aria-hidden="true"></i>
                          <span class="sr-only">
                            <?php echo e(trans('general.files')); ?>

                          </span>
                          <?php echo ($location->uploads()->count() > 0 ) ? '<span class="badge">'.number_format($location->uploads()->count()).'</span>' : ''; ?>

                      </span>
                  </a>
              </li>





              <li>
                  <a href="#history" data-toggle="tab" data-tooltip="true" title="<?php echo e(trans('general.history')); ?>">
                      <i class="fa-solid fa-clock-rotate-left fa-fw" style="font-size: 17px" aria-hidden="true"></i>
                      <span class="sr-only">
                          <?php echo e(trans('general.history')); ?>

                    </span>
                  </a>
              </li>

              <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('update', $location)): ?>
              <li class="pull-right">
                  <a href="#" data-toggle="modal" data-target="#uploadFileModal">
                      <?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => '53a84532857250ffb7b99fa272c3af08::icon','data' => ['type' => 'paperclip']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'paperclip']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $attributes = $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $component = $__componentOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
                      <?php echo e(trans('button.upload')); ?>

                  </a>
              </li>
              <?php endif; ?>
          </ul>


          <div class="tab-content">
              <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view', \App\Models\User::class)): ?>
                    <div id="users" class="<?php echo \Illuminate\Support\Arr::toCssClasses(['tab-pane','active']); ?>" >
              <?php endif; ?>
                  <h2 class="box-title"><?php echo e(trans('general.users')); ?></h2>
                      <?php echo $__env->make('partials.users-bulk-actions', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                      <table
                              data-columns="<?php echo e(\App\Presenters\UserPresenter::dataTableLayout()); ?>"
                              data-cookie-id-table="usersTable"
                              data-id-table="usersTable"
                              data-side-pagination="server"
                              data-sort-order="asc"
                              data-toolbar="#userBulkEditToolbar"
                              data-bulk-button-id="#bulkUserEditButton"
                              data-bulk-form-id="#usersBulkForm"
                              id="usersTable"
                              data-buttons="userButtons"
                              class="table table-striped snipe-table"
                              data-url="<?php echo e(route('api.users.index', ['location_id' => $location->id])); ?>"
                              data-export-options='{
                              "fileName": "export-locations-<?php echo e(str_slug($location->name)); ?>-users-<?php echo e(date('Y-m-d')); ?>",
                              "ignoreColumn": ["actions","image","change","checkbox","checkincheckout","icon"]
                              }'>
                      </table>
                    </div><!-- /.tab-pane -->
                <div id="assets" class="<?php echo \Illuminate\Support\Arr::toCssClasses(['tab-pane']); ?>" >

                  <h2 class="box-title"><?php echo e(trans('admin/locations/message.current_location')); ?></h2>

                      <?php echo $__env->make('partials.asset-bulk-actions', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                      <table
                              data-columns="<?php echo e(\App\Presenters\AssetPresenter::dataTableLayout()); ?>"
                              data-show-columns-search="true"
                              data-cookie-id-table="assetsListingTable"
                              data-id-table="assetsListingTable"
                              data-side-pagination="server"
                              data-sort-order="asc"
                              data-toolbar="#assetsBulkEditToolbar"
                              data-bulk-button-id="#bulkAssetEditButton"
                              data-bulk-form-id="#assetsBulkForm"
                              id="assetsListingTable"
                              data-buttons="assetButtons"
                              class="table table-striped snipe-table"
                              data-url="<?php echo e(route('api.assets.index', ['location_id' => $location->id])); ?>"
                              data-export-options='{
                              "fileName": "export-locations-<?php echo e(str_slug($location->name)); ?>-assets-<?php echo e(date('Y-m-d')); ?>",
                              "ignoreColumn": ["actions","image","change","checkbox","checkincheckout","icon"]
                              }'>
                      </table>
              </div><!-- /.tab-pane -->

              <div class="tab-pane" id="assets_assigned">
                  <h2 class="box-title">
                      <?php echo e(trans('admin/locations/message.assigned_assets')); ?>

                  </h2>

                      <?php echo $__env->make('partials.asset-bulk-actions', ['id_divname' => 'AssignedAssetsBulkEditToolbar', 'id_formname' => 'assignedAssetsBulkForm', 'id_button' => 'AssignedbulkAssetEditButton'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                      <table
                              role="table"
                              data-columns="<?php echo e(\App\Presenters\AssetPresenter::dataTableLayout()); ?>"
                              data-show-columns-search="true"
                              data-cookie-id-table="assetsAssignedListingTable"
                              data-id-table="assetsAssignedListingTable"
                              data-side-pagination="server"
                              data-sort-order="asc"
                              data-toolbar="#AssignedAssetsBulkEditToolbar"
                              data-bulk-button-id="#AssignedbulkAssetEditButton"
                              data-bulk-form-id="#assignedAssetsBulkForm"
                              id="assetsAssignedListingTable"
                              data-buttons="assetButtons"
                              class="table table-striped snipe-table"
                              data-url="<?php echo e(route('api.assets.index', ['assigned_to' => $location->id, 'assigned_type' => 'App\Models\Location'])); ?>"
                              data-export-options='{
                              "fileName": "export-locations-<?php echo e(str_slug($location->name)); ?>-assets-<?php echo e(date('Y-m-d')); ?>",
                              "ignoreColumn": ["actions","image","change","checkbox","checkincheckout","icon"]
                              }'>
                      </table>
              </div><!-- /.tab-pane -->

              <div class="tab-pane" id="rtd_assets">
                  <h2 class="box-title"><?php echo e(trans('admin/hardware/form.default_location')); ?></h2>

                      <?php echo $__env->make('partials.asset-bulk-actions', ['id_divname' => 'RTDassetsBulkEditToolbar', 'id_formname' => 'RTDassets', 'id_button' => 'RTDbulkAssetEditButton'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                      <table
                              role="table"
                              data-columns="<?php echo e(\App\Presenters\AssetPresenter::dataTableLayout()); ?>"
                              data-show-columns-search="true"
                              data-cookie-id-table="RTDassetsListingTable"
                              data-id-table="RTDassetsListingTable"
                              data-side-pagination="server"
                              data-sort-order="asc"
                              data-toolbar="#RTDassetsBulkEditToolbar"
                              data-bulk-button-id="#RTDbulkAssetEditButton"
                              data-bulk-form-id="#RTDassetsBulkEditToolbar"
                              id="RTDassetsListingTable"
                              data-buttons="assetButtons"
                              class="table table-striped snipe-table"
                              data-url="<?php echo e(route('api.assets.index', ['rtd_location_id' => $location->id])); ?>"
                              data-export-options='{
                              "fileName": "export-rtd-locations-<?php echo e(str_slug($location->name)); ?>-assets-<?php echo e(date('Y-m-d')); ?>",
                              "ignoreColumn": ["actions","image","change","checkbox","checkincheckout","icon"]
                              }'>
                      </table>
              </div><!-- /.tab-pane -->
              


              <div class="tab-pane" id="accessories">
                  <h2 class="box-title"><?php echo e(trans('general.accessories')); ?></h2>
                      <table
                              role="table"
                              data-columns="<?php echo e(\App\Presenters\AccessoryPresenter::dataTableLayout()); ?>"
                              data-cookie-id-table="accessoriesListingTable"
                              data-id-table="accessoriesListingTable"
                              data-side-pagination="server"
                              data-sort-order="asc"
                              id="accessoriesListingTable"
                              data-buttons="accessoryButtons"
                              class="table table-striped snipe-table"
                              data-url="<?php echo e(route('api.accessories.index', ['location_id' => $location->id])); ?>"
                              data-export-options='{
                              "fileName": "export-locations-<?php echo e(str_slug($location->name)); ?>-accessories-<?php echo e(date('Y-m-d')); ?>",
                              "ignoreColumn": ["actions","image","change","checkbox","checkincheckout","icon"]
                              }'>
                      </table>
              </div><!-- /.tab-pane -->

              <div class="tab-pane" id="accessories_assigned">
                      <h2 class="box-title" style="float:left">
                          <?php echo e(trans('general.accessories_assigned')); ?>

                      </h2>

                      <table
                              role="table"
                              data-columns="<?php echo e(\App\Presenters\LocationPresenter::assignedAccessoriesDataTableLayout()); ?>"
                              data-cookie-id-table="accessoriesAssignedListingTable"
                              data-id-table="accessoriesAssignedListingTable"
                              data-side-pagination="server"
                              data-sort-order="asc"
                              id="accessoriesAssignedListingTable"
                              data-buttons="accessoryButtons"
                              class="table table-striped snipe-table"
                              data-url="<?php echo e(route('api.locations.assigned_accessories', ['location' => $location])); ?>"
                              data-export-options='{
                              "fileName": "export-locations-<?php echo e(str_slug($location->name)); ?>-accessories-<?php echo e(date('Y-m-d')); ?>",
                              "ignoreColumn": ["actions","image","change","checkbox","checkincheckout","icon"]
                              }'>
                      </table>
              </div><!-- /.tab-pane -->


              <div class="tab-pane" id="consumables">
                  <h2 class="box-title"><?php echo e(trans('general.consumables')); ?></h2>
                          <table
                                  role="table"
                                  data-columns="<?php echo e(\App\Presenters\ConsumablePresenter::dataTableLayout()); ?>"
                                  data-cookie-id-table="consumablesListingTable"
                                  data-id-table="consumablesListingTable"
                                  data-side-pagination="server"
                                  data-sort-order="asc"
                                  id="consumablesListingTable"
                                  data-buttons="consumableButtons"
                                  class="table table-striped snipe-table"
                                  data-url="<?php echo e(route('api.consumables.index', ['location_id' => $location->id])); ?>"
                                  data-export-options='{
                              "fileName": "export-locations-<?php echo e(str_slug($location->name)); ?>-consumables-<?php echo e(date('Y-m-d')); ?>",
                              "ignoreColumn": ["actions","image","change","checkbox","checkincheckout","icon"]
                              }'>
                          </table>
              </div><!-- /.tab-pane -->

              <div class="tab-pane" id="components">
                  <h2 class="box-title"><?php echo e(trans('general.components')); ?></h2>
                          <table
                                  role="table"
                                  data-columns="<?php echo e(\App\Presenters\ComponentPresenter::dataTableLayout()); ?>"
                                  data-cookie-id-table="componentsTable"
                                  data-id-table="componentsTable"
                                  data-side-pagination="server"
                                  data-sort-order="asc"
                                  id="componentsTable"
                                  data-buttons="componentButtons"
                                  class="table table-striped snipe-table"
                                  data-url="<?php echo e(route('api.components.index', ['location_id' => $location->id])); ?>"
                                  data-export-options='{
                              "fileName": "export-locations-<?php echo e(str_slug($location->name)); ?>-components-<?php echo e(date('Y-m-d')); ?>",
                              "ignoreColumn": ["actions","image","change","checkbox","checkincheckout","icon"]
                              }'>
                          </table>
              </div><!-- /.tab-pane -->


                      <div class="tab-pane" id="child_locations">
                          <h2 class="box-title">
                              <?php echo e(trans('general.child_locations')); ?>

                          </h2>
                          <table
                                  role="table"
                                  data-columns="<?php echo e(\App\Presenters\LocationPresenter::dataTableLayout()); ?>"
                                  data-cookie-id-table="childrenListingTable"
                                  data-id-table="childrenListingTable"
                                  data-side-pagination="server"
                                  data-sort-order="asc"
                                  id="childrenListingTable"
                                  data-buttons="childrenListingTable"
                                  class="table table-striped snipe-table"
                                  data-url="<?php echo e(route('api.locations.index', ['parent_id' => $location->id])); ?>"
                                  data-export-options='{
                              "fileName": "export-children-locations-<?php echo e(str_slug($location->name)); ?>-<?php echo e(date('Y-m-d')); ?>",
                              "ignoreColumn": ["actions","image","change","checkbox","checkincheckout","icon"]
                              }'>
                          </table>
                      </div><!-- /.tab-pane -->

                  <div class="tab-pane fade" id="files">
                      <h2 class="box-title">
                          <?php echo e(trans('general.child_locations')); ?>

                      </h2>

                      <div class="row">
                          <div class="col-md-12">
                              <?php if (isset($component)) { $__componentOriginal0719d4299c67785b885b02286823a390 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0719d4299c67785b885b02286823a390 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => '53a84532857250ffb7b99fa272c3af08::filestable','data' => ['objectType' => 'locations','object' => $location]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filestable'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['object_type' => 'locations','object' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($location)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal0719d4299c67785b885b02286823a390)): ?>
<?php $attributes = $__attributesOriginal0719d4299c67785b885b02286823a390; ?>
<?php unset($__attributesOriginal0719d4299c67785b885b02286823a390); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal0719d4299c67785b885b02286823a390)): ?>
<?php $component = $__componentOriginal0719d4299c67785b885b02286823a390; ?>
<?php unset($__componentOriginal0719d4299c67785b885b02286823a390); ?>
<?php endif; ?>
                          </div> <!-- /.col-md-12 -->
                      </div> <!-- /.row -->
                  </div>


                  <div class="tab-pane" id="accessories_assigned">
                      <h2 class="box-title" style="float:left">
                          <?php echo e(trans('general.accessories_assigned')); ?>

                      </h2>

                      <table
                              role="table"
                              data-columns="<?php echo e(\App\Presenters\LocationPresenter::assignedAccessoriesDataTableLayout()); ?>"
                              data-cookie-id-table="accessoriesAssignedListingTable"
                              data-id-table="accessoriesAssignedListingTable"
                              data-side-pagination="server"
                              data-sort-order="asc"
                              id="accessoriesAssignedListingTable"
                              data-buttons="accessoryButtons"
                              class="table table-striped snipe-table"
                              data-url="<?php echo e(route('api.locations.assigned_accessories', ['location' => $location])); ?>"
                              data-export-options='{
                              "fileName": "export-locations-<?php echo e(str_slug($location->name)); ?>-accessories-<?php echo e(date('Y-m-d')); ?>",
                              "ignoreColumn": ["actions","image","change","checkbox","checkincheckout","icon"]
                              }'>
                      </table>
                  </div><!-- /.tab-pane -->

                <div class="tab-pane" id="history">
                    <h2 class="box-title"><?php echo e(trans('general.history')); ?></h2>
                    <!-- checked out assets table -->
                    <div class="row">
                        <div class="col-md-12">
                            <table
                                    data-columns="<?php echo e(\App\Presenters\HistoryPresenter::dataTableLayout()); ?>"
                                    class="table table-striped snipe-table"
                                    id="locationHistory"
                                    data-id-table="locationHistory"
                                    data-side-pagination="server"
                                    data-sort-order="desc"
                                    data-sort-name="created_at"
                                    data-export-options='{
                                        "fileName": "export-location-asset-<?php echo e($location->id); ?>-history",
                                        "ignoreColumn": ["actions","image","change","checkbox","checkincheckout","icon"]
                                    }'
                                    data-url="<?php echo e(route('api.activity.index', ['target_id' => $location->id, 'target_type' => 'location'])); ?>"
                                    data-cookie-id-table="locationHistory"
                                    data-cookie="true">
                            </table>
                        </div>
                    </div> <!-- /.row -->
                </div> <!-- /.tab-pane history -->

          </div><!--/.col-md-9-->
      </div><!--/.col-md-9-->
  </div><!--/.col-md-9-->

  <div class="col-md-3">

      <?php if($location->image!=''): ?>
          <div class="col-md-12 text-center" style="padding-bottom: 17px;">
              <img src="<?php echo e(Storage::disk('public')->url('locations/'.e($location->image))); ?>" class="img-responsive img-thumbnail" style="width:100%" alt="<?php echo e($location->name); ?>">
          </div>
      <?php endif; ?>

      <?php if(($location->state!='') && ($location->country!='') && (config('services.google.maps_api_key'))): ?>
          <div class="col-md-12 text-center" style="padding-bottom: 10px;">
              <img src="https://maps.googleapis.com/maps/api/staticmap?markers=<?php echo e(urlencode($location->address.','.$location->city.' '.$location->state.' '.$location->country.' '.$location->zip)); ?>&size=700x500&maptype=roadmap&key=<?php echo e(config('services.google.maps_api_key')); ?>" class="img-thumbnail" style="width:100%" alt="Map">
          </div>
      <?php endif; ?>

      <div class="col-md-12">

          <ul class="list-unstyled" style="line-height: 22px; padding-bottom: 20px;">

              <?php if($location->notes): ?>
                  <li>
                      <strong><?php echo e(trans('general.notes')); ?></strong>:
                      <?php echo nl2br(Helper::parseEscapedMarkedownInline($location->notes)); ?>

                  </li>
              <?php endif; ?>

              <?php if($location->address!=''): ?>
                  <li><?php echo e($location->address); ?></li>
              <?php endif; ?>
              <?php if($location->address2!=''): ?>
                  <li><?php echo e($location->address2); ?></li>
              <?php endif; ?>
              <?php if(($location->city!='') || ($location->state!='') || ($location->zip!='')): ?>
                  <li><?php echo e($location->city); ?> <?php echo e($location->state); ?> <?php echo e($location->zip); ?></li>
              <?php endif; ?>
              <?php if($location->manager): ?>
                  <li><strong><?php echo e(trans('admin/users/table.manager')); ?></strong>: <?php echo $location->manager->present()->nameUrl(); ?></li>
              <?php endif; ?>
              <?php if($location->company): ?>
                  <li><strong><?php echo e(trans('admin/companies/table.name')); ?></strong>: <?php echo $location->company->present()->nameUrl(); ?></li>
              <?php endif; ?>
              <?php if($location->parent): ?>
                  <li><strong><?php echo e(trans('admin/locations/table.parent')); ?></strong>: <?php echo $location->parent->present()->nameUrl(); ?></li>
              <?php endif; ?>
              <?php if($location->ldap_ou): ?>
                  <li><strong><?php echo e(trans('admin/locations/table.ldap_ou')); ?></strong>: <?php echo e($location->ldap_ou); ?></li>
              <?php endif; ?>


              <?php if((($location->address!='') && ($location->city!='')) || ($location->state!='') || ($location->country!='')): ?>
                      <li>
                        <a href="https://maps.google.com/?q=<?php echo e(urlencode($location->address.','. $location->city.','.$location->state.','.$location->country.','.$location->zip)); ?>" target="_blank">
                            <?php echo trans('admin/locations/message.open_map', ['map_provider_icon' => '<i class="fa-brands fa-google" aria-hidden="true"></i>']); ?>

                            <?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => '53a84532857250ffb7b99fa272c3af08::icon','data' => ['type' => 'external-link']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'external-link']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $attributes = $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $component = $__componentOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
                        </a>
                      </li>
                      <li>
                        <a href="https://maps.apple.com/?q=<?php echo e(urlencode($location->address.','. $location->city.','.$location->state.','.$location->country.','.$location->zip)); ?>" target="_blank">
                            <?php echo trans('admin/locations/message.open_map', ['map_provider_icon' => '<i class="fa-brands fa-apple" aria-hidden="true" style="font-size: 18px"></i>']); ?>

                            <?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => '53a84532857250ffb7b99fa272c3af08::icon','data' => ['type' => 'external-link']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'external-link']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $attributes = $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $component = $__componentOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?></a>
                  </li>
              <?php endif; ?>

          </ul>
      </div>

      <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('update', $location)): ?>
          <?php if($location->deleted_at==''): ?>
              <div class="col-md-12">
                  <a href="<?php echo e(route('locations.edit', ['location' => $location->id])); ?>" style="width: 100%;" class="btn btn-sm btn-warning btn-social">
                      <?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => '53a84532857250ffb7b99fa272c3af08::icon','data' => ['type' => 'edit']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'edit']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $attributes = $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $component = $__componentOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
                      <?php echo e(trans('admin/locations/table.update')); ?>

                  </a>
              </div>
              <?php else: ?>
              <div class="col-md-12">
                  <a style="width: 100%;" class="btn btn-sm btn-warning btn-social disabled">
                      <?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => '53a84532857250ffb7b99fa272c3af08::icon','data' => ['type' => 'edit']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'edit']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $attributes = $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $component = $__componentOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
                      <?php echo e(trans('admin/locations/table.update')); ?>

                  </a>
              </div>
              <?php endif; ?>
      <?php endif; ?>

     <?php if($location->deleted_at==''): ?>
      <div class="col-md-12" style="padding-top: 5px;">
          <a href="<?php echo e(route('locations.print_assigned', ['locationId' => $location->id])); ?>" style="width: 100%;" class="btn btn-sm btn-primary btn-social hidden-print">
              <?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => '53a84532857250ffb7b99fa272c3af08::icon','data' => ['type' => 'print']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'print']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $attributes = $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $component = $__componentOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
              <?php echo e(trans('admin/locations/table.print_inventory')); ?>

          </a>
      </div>
      <div class="col-md-12" style="padding-top: 5px;">
          <a href="<?php echo e(route('locations.print_all_assigned', ['locationId' => $location->id])); ?>" style="width: 100%;" class="btn btn-sm btn-primary btn-social hidden-print">
              <?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => '53a84532857250ffb7b99fa272c3af08::icon','data' => ['type' => 'print']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'print']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $attributes = $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $component = $__componentOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
              <?php echo e(trans('admin/locations/table.print_all_assigned')); ?>

          </a>
      </div>
      <?php endif; ?>

          <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('delete', $location)): ?>
              <div class="col-md-12 hidden-print" style="padding-top: 10px;">

            <?php if($location->deleted_at==''): ?>

                <?php if($location->isDeletable()): ?>
                      <button class="btn btn-sm btn-block btn-danger btn-social delete-asset" data-toggle="modal" data-title="<?php echo e(trans('general.delete')); ?>" data-content="<?php echo e(trans('general.sure_to_delete_var', ['item' => $location->name])); ?>" data-target="#dataConfirmModal">
                          <?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => '53a84532857250ffb7b99fa272c3af08::icon','data' => ['type' => 'delete']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'delete']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $attributes = $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $component = $__componentOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
                          <?php echo e(trans('general.delete')); ?>

                      </button>
                <?php else: ?>
                      <span data-placement="top" data-tooltip="true" data-title="<?php echo e(trans('admin/locations/message.assoc_users')); ?>">
                          <a href="#" class="btn btn-block btn-sm btn-danger btn-social hidden-print disabled" data-tooltip="true">
                          <?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => '53a84532857250ffb7b99fa272c3af08::icon','data' => ['type' => 'delete']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'delete']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $attributes = $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $component = $__componentOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
                          <?php echo e(trans('general.delete')); ?>

                      </a>
                          </span>
                <?php endif; ?>

            <?php else: ?>
                  <form method="POST" action="<?php echo e(route('locations.restore', ['location' => $location->id])); ?>">
                      <?php echo csrf_field(); ?>
                      <button class="btn btn-sm btn-block btn-warning btn-social">
                          <?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => '53a84532857250ffb7b99fa272c3af08::icon','data' => ['type' => 'restore']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'restore']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $attributes = $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $component = $__componentOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
                          <?php echo e(trans('general.restore')); ?>

                      </button>
                  </form>
            <?php endif; ?>
              </div>
    <?php endif; ?>



</div>
</div>


<?php $__env->stopSection(); ?>

<?php $__env->startSection('moar_scripts'); ?>

    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('update', Location::class)): ?>
        <?php echo $__env->make('modals.upload-file', ['item_type' => 'locations', 'item_id' => $location->id], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php endif; ?>


<?php echo $__env->make('partials.bootstrap-table', [
'exportFile' => 'locations-export',
'search' => true
], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts/default', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laravel\backup\snipe-it-8.3.3 - Copy\resources\views/locations/view.blade.php ENDPATH**/ ?>
<div class="panel">
    <h3><i class="icon-cogs"></i> {$title|escape:'htmlall':'UTF-8'}</h3>
    <form id="module_form" class="defaultForm form-horizontal" action="{$action|escape:'htmlall':'UTF-8'}" method="post">
        <div class="form-group">
            <label class="control-label col-lg-3">{$label|escape:'htmlall':'UTF-8'}</label>
            <div class="col-lg-9">
                <input type="text" name="TOPHEADER_TEXT" value="{$value|escape:'htmlall':'UTF-8'}">
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-lg-3">{$label_switch|escape:'htmlall':'UTF-8'}</label>
            <div class="col-lg-9">
                <input type="checkbox" name="TOPHEADER_DISPLAY" value="1"{if $display_value} checked="checked"{/if}>
            </div>
        </div>
        <button type="submit" value="1" id="module_form_submit_btn" class="btn btn-default pull-right" name="submitUpdate">
            <i class="process-icon-save"></i> Save
        </button>
    </form>
</div>

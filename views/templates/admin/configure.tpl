<div class="panel">
    <h3><i class="icon-cogs"></i> {l s='Top Header Settings' d='Modules.TopHeader.Admin'}</h3>
    <form id="module_form" class="defaultForm form-horizontal" action="{$action|escape:'htmlall':'UTF-8'}" method="post">
        <div class="form-group">
            <label class="control-label col-lg-3">{l s='Top Header Text' d='Modules.TopHeader.Admin'}</label>
            <div class="col-lg-9">
                <input type="text" name="TOPHEADER_TEXT" value="{$value|escape:'htmlall':'UTF-8'}">
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-lg-3">{l s='Top Header Display' d='Modules.TopHeader.Admin'}</label>
            <div class="col-lg-9">
                <input type="checkbox" name="TOPHEADER_DISPLAY" value="1"{if $display_value} checked="checked"{/if}>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-lg-3">{l s='Text Color' d='Modules.TopHeader.Admin'}</label>
            <div class="col-lg-9">
                <input type="color" name="TOPHEADER_TEXT_COLOR" value="{$text_color_value|escape:'htmlall':'UTF-8'}">
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-lg-3">{l s='Background Color' d='Modules.TopHeader.Admin'}</label>
            <div class="col-lg-9">
                <input type="color" name="TOPHEADER_BG_COLOR" value="{$bg_color_value|escape:'htmlall':'UTF-8'}">
            </div>
        </div>

        <button type="submit" value="1" id="module_form_submit_btn" class="btn btn-default pull-right" name="submitUpdate">
            <i class="process-icon-save"></i> {l s='Save' d='Modules.TopHeader.Admin'}
        </button>
    </form>
</div>


<div id="config-taxonomy" class="config-taxonomy" style="display:none;">

	<div class="ymc-tax-content">

		<div class="btn-setting-wrp">
			<a href="#" class="btn-tax-apply"><?php esc_html_e('Apply', 'ymc-smart-filter'); ?></a>
		</div>

		<div class="tax-entry">
			<div class="form-element">
				<label class="form-label">
					<?php esc_html_e('Background', 'ymc-smart-filter'); ?>
					<span class="information">
                            <?php echo esc_html__('Set taxonomy background .', 'ymc-smart-filter');?>
                        </span>
				</label>
				<input class="ymc-custom-color ymc-tax-bg" id="ymc-tax-bg" type="text" name='ymc-tax-bg' value=""/>
			</div>
			<div class="form-element">
				<label class="form-label">
					<?php esc_html_e('Color', 'ymc-smart-filter'); ?>
					<span class="information">
                            <?php echo esc_html__('Set taxonomy color.', 'ymc-smart-filter');?>
                        </span>
				</label>
				<input class="ymc-custom-color ymc-tax-color" id="ymc-tax-color" type="text"  name='ymc-tax-color' value=""/>
			</div>
			<div class="form-element">
				<label class="form-label">
					<?php esc_html_e('Name', 'ymc-smart-filter'); ?>
					<span class="information">
                            <?php echo esc_html__('Set a custom taxonomy name.', 'ymc-smart-filter');?>
                        </span>
				</label>
				<input class="input-field ymc-tax-custom-name" id="ymc-tax-custom-name" type="text" name="ymc-tax-custom-name" placeholder="Taxonomy custom name" value="" />
			</div>
		</div>
	</div>

</div>
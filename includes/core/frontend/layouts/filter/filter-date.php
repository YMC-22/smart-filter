<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>

<div id="<?php echo esc_attr($ymc_filter_layout); ?>-<?php echo esc_attr($c_target); ?>" class="filter-layout <?php echo esc_attr($ymc_filter_layout); ?> <?php echo esc_attr($ymc_filter_layout); ?>-<?php echo esc_attr($id); ?> <?php echo esc_attr($ymc_filter_layout); ?>-<?php echo esc_attr($id); ?>-<?php echo esc_attr($c_target); ?>">

	<div class="filter-wrapper">

			<div class="date-ranges filter-wrapper__item">

				<div class="date-ranges__label">
					<?php esc_html_e('Date', 'ymc-smart-filter'); ?>
				</div>

				<div class="date-ranges__selected">
					<?php esc_html_e('All', 'ymc-smart-filter'); ?>
				</div>

				<div class="date-ranges__dropdown">
					<ul class="date-ranges__list">
						<li class="list-item">
							<span data-date="all"><?php esc_html_e('All', 'ymc-smart-filter'); ?></span>
						</li>
						<li class="list-item">
							<span data-date="today"><?php esc_html_e('Today', 'ymc-smart-filter'); ?></span>
						</li>
						<li class="list-item">
							<span data-date="yesterday"><?php esc_html_e('Yesterday', 'ymc-smart-filter'); ?></span>
						</li>
						<li class="list-item">
							<span data-date="3_days"><?php esc_html_e('Last 3 days', 'ymc-smart-filter'); ?></span>
						</li>
						<li class="list-item">
							<span data-date="week"><?php esc_html_e('Last week', 'ymc-smart-filter'); ?></span>
						</li>
						<li class="list-item">
							<span data-date="month"><?php esc_html_e('Last month', 'ymc-smart-filter'); ?></span>
						</li>
						<li class="list-item">
							<span data-date="year"><?php esc_html_e('Last year', 'ymc-smart-filter'); ?></span>
						</li>
						<li class="list-item">
							<span data-date="other"><?php esc_html_e('Other...', 'ymc-smart-filter'); ?></span>
						</li>
					</ul>
				</div>

			</div>

			<div class="date-ranges-custom filter-wrapper__item">

				<div class="message"></div>

				<div class="date-ranges-custom__container">
					<div class="datepickerForm">
						<header class="header"><?php esc_attr_e('From', 'ymc-smart-filter'); ?></header>
						<input class="datepicker" type="text" name="date_from"
						       data-timestamp="<?php echo strtotime(date("Y-m-d")); ?>" value="<?php echo date('M d, Y'); ?>">
					</div>
					<div class="datepickerForm">
						<header class="header"><?php esc_attr_e('To', 'ymc-smart-filter'); ?></header>
						<input class="datepicker" type="text" name="date_to"
						       data-timestamp="<?php echo strtotime(date("Y-m-d")); ?>" value="<?php echo date('M d, Y'); ?>">
					</div>
					<div class="datepickerForm">
						<button class="btn-apply"><?php esc_attr_e('Apply', 'ymc-smart-filter'); ?></button>
						<button class="btn-cancel"><?php esc_attr_e('Cancel', 'ymc-smart-filter'); ?></button>
					</div>
				</div>

			</div>

		</div>

</div>



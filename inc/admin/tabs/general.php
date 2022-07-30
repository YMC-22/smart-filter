
<div class="header">
	<?php echo esc_html__('General Options', 'ymc-smart-filter'); ?>
</div>

<div class="content">

<div class="form-group wrapper-cpt">

	<label for="ymc-cpt-select" class="form-label">
		<?php echo esc_html__('Custom Post Type','ymc-smart-filter'); ?>
		<span class="information">
        <?php echo esc_html__('Select post type.','ymc-smart-filter'); ?>
        </span>
	</label>

	<select class="form-select" id="ymc-cpt-select" name="ymc-cpt-select" data-postid="<?php echo $post->ID; ?>">
		<option value="post"><?php echo esc_html__('Post','ymc-smart-filter'); ?></option>
		<?php
		foreach($cpost_types as $cpost_type) {
		    //if($cpost_type !== 'page') {
			    if($cpt === $cpost_type) {
				    $sel = 'selected';
			    } else {
				    $sel = '';
			    }
			    echo "<option value='" . $cpost_type ."' $sel>" . esc_html($cpost_type) . "</option>";
            //}
		}
		?>
	</select>

</div>

<hr/>

<div class="form-group wrapper-taxonomy">

	<label for="ymc-tax-checkboxes" class="form-label">
		<?php echo esc_html__('Taxonomy','ymc-smart-filter'); ?>
		<span class="information">
        <?php echo esc_html__('Select taxonomy.','ymc-smart-filter'); ?>
        </span>
	</label>

    <div id="ymc-tax-checkboxes" class="ymc-tax-checkboxes">

	    <?php

            $taxo = get_object_taxonomies($cpt);

            if($taxo) {

                foreach($taxo as $val) :

                    $sl0 = '';

                    if(is_array($tax_sel) && count($tax_sel) > 0) {

                        if (in_array($val, $tax_sel)) {
                            $sl0 = 'checked';
                        }
                        else{
                            $sl0 ='';
                        }
                    }

                    echo '<div class="group-elements">
                            <input id="id-'. esc_html($val) .'" type="checkbox" name="ymc-taxonomy[]" value="'. esc_html($val) .'" '.$sl0.'>
                            <label for="id-'. esc_html($val) .'">'. esc_html($val) . '</label>
                         </div>';

                endforeach;
            }
            else {
              echo '<span class="notice">'. esc_html__('No data for Post Type / Taxonomy', 'ymc-smart-filter') .'</span>';
            }
	    ?>

    </div>

</div>

<hr/>

<div class="form-group wrapper-terms <?php echo empty($tax_sel) ? 'hidden' : ''; ?>">

	<label for="ymc-terms" class="form-label">
		<?php echo esc_html__('Terms','ymc-smart-filter'); ?>
		<span class="information"><?php echo esc_html__('Select terms','ymc-smart-filter'); ?></span>
	</label>

	<div class="category-list" id="ymc-terms">

		<?php

        if( is_array($tax_sel) && count($tax_sel) > 0 ) {

            foreach ( $tax_sel as $tax ) :

	            $terms = get_terms([
		            'taxonomy' => $tax,
		            'hide_empty' => false,
	            ]);

	            if( $terms ) {

                    echo '<article class="group-term item-'. $tax .'">';

                    echo '<div class="item-inner all-categories">
                          <header class="header-tax">'. esc_html__('Taxonomy', 'ymc-smart-filter') .': '.$tax.'</header>
                          <input name="all-select" class="category-all" id="category-all-'.$tax.'" type="checkbox">
                          <label for="category-all-'.$tax.'" class="category-all-label">'. esc_html__('All', 'ymc-smart-filter') .'</label></div>';

		            foreach( $terms as $term ) :

			            $sl1 = '';

			            if(is_array($terms_sel) && count($terms_sel) > 0) {

                            if (in_array($term->term_id, $terms_sel)) {
                                $sl1 = 'checked';
                            }
                            else{ $sl1 = ''; }
			            }

			            echo '<div class="item-inner">
                              <input name="ymc-terms[]" class="category-list" id="category-id-'.$term->term_id.'" type="checkbox" value="'. $term->term_id .'" '.$sl1.'>';
			            echo '<label for="category-id-'.$term->term_id.'" class="category-list-label">' . esc_html($term->name) . '</label></div>';

                   endforeach;

                   echo '</article>';
	            }

            endforeach;
        }
        ?>

	</div>

</div>

</div>


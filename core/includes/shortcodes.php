<?php
/*******************************************************************
* BUILD THE SHORTCODE
********************************************************************/
// [ajax_filter_search]
function ajax_filter_search($atts, $content = null) {
    extract(shortcode_atts(array(
		'post_type'				=> AFSAdmin::afs_retrieve('_general_post_type'),
		'post_tax' 				=> AFSAdmin::afs_retrieve('_general_post_taxonomy'),
		'posts_per_page'		=> AFSAdmin::afs_retrieve('_general_posts_per_page'),
		'filter_type'			=> '',
		'filter_by' 				=> '',
		'filter_months' 			=> '',
		'filter_years' 			=> '',
		'filter_withPDF' 		=> '',
        'offset' 				=> 0,
        'filter_tabs'           => '',
        'all_filter'            => 'all',
    ), $atts));
    $filter_by_array = explode(',', $filter_tabs);
	// Build String to attach to [afs_feed] to allow for custom building
	$afs_args = '';
	if($post_type == '') { } else { $afs_args .=' post_type="'.$post_type.'" '; }
	if($posts_per_page == '') { } else { $afs_args .=' posts_per_page="'.$posts_per_page.'" '; }
	if($filter_by == '') { } else { $afs_args .=' filter_by="'.$filter_by.'" '; }
	if($filter_months == '') { } else { $afs_args .=' filter_months="'.$filter_months.'" '; }
	if($filter_years == '') { } else { $afs_args .=' filter_years="'.$filter_years.'" '; }
	if($filter_withPDF == '') { } else { $afs_args .=' filter_withPDF="'.$filter_withPDF.'" '; }
	if($offset == '') { } else { $afs_args .=' offset="'.$offset.'" '; }

	if($filter_type == '') {
		$all='all';
		$filter_type_count = 999;
	} else {
		$afs_args .=' filter_type="'.$filter_type.'" ';
		$all=$filter_type;
		$filter_type_array = explode(',',$filter_type);
		$filter_type_count = count($filter_type_array);
	}

	$text = '';
	$i = 1;

	/****************************
	Template Header
	****************************/
	$text .= '<main class="hero" role="main">';
	$text .= '	<section class="container resources">';
	$text .= '		<div class="row">';
    $text .= '           <div class="grid-full ">';
	$text .= '<div id="afs-wrapper">';
	$text .= '	<div class="press-releases">';
	$text .= '		<form id="newsForm">';
	$text .= '			<div class="row">';


	$text .= '				<div class="col-xs-12">';

    $text .= '					<div class="afs-Filters row">';
    if(AFSAdmin::afs_retrieve('_general_views') == 1) {

	$text .= '				<div id="newsViewOptionsPanel" class="afs-Switch col-xs-12 col-sm-5" style="display: block;">';
	$text .= '					<ul class="pull-left">';
	$text .= '						<li class="active"><a rel="listPR" href="javascript:;"><span class="fa fa-list-ul"></span>&nbsp;List View</a></li>';
	$text .= '						<li><a rel="gridPR" href="javascript:;"><span class="fa fa-th"></span>&nbsp;Grid View</a></li>';
	$text .= '					</ul>';
	$text .= '				</div>';

	} else {

    $text .= '        		<br />';

	}



    $text .= '    <div class="col-xs-12">';
    $text .= '        <h2 class="headline">Resources</h2>';
    $text .= '        <h2 class="sub-headline">Our collection of helpful resources.</h2>';
	/****************************
	Search Filters
	****************************/
	$text .= '							<div class="afs-FilterPanel1 col-xs-12 col-md-6 col-md-offset-3">';
	$text .= '									<div class="">';
	$text .= '										<div class="form-group-inline has-feedback">';

	$text .= '										<!-- SEARCH -->';
    $text .= '                						<div class="" hidden="true">';
    $text .= '                   						<button type="button" id="updateBtn" class="btn btn-primary">Search</button>';
	$text .= '											<button type="button" id="resetBtn" class="btn btn-default reset">Reset</button>';
    $text .= '               						</div>';
	$text .= '											<div class="">';
	$text .= '												<input type="text" class="form-control" name="filterBy">';
	$text .= '												<span class="fa fa-search form-control-feedback filterBy"></span>';
	$text .= '											</div>';
	$text .= '										<!-- END SEARCH -->';

    $text .= '                                  </div>';
    $text .= '						</div>';
    $text .= '					</div>';
    $text .= '				</div><!-- END .col-xs-1TableRowItem2 -->';
    $text .= '				<div class="clearfix"></div>';
    $text .= '    </div>';

	/****************************
	Top Tabs
	****************************/

	if(AFSAdmin::afs_retrieve('_general_show_filters') == 1 && $filter_type_count > 1) {
	$taxonomy = AFSAdmin::afs_retrieve('_general_post_taxonomy');
    if($taxonomy == 'none' || $taxonomy == '') {
		} else {

            $text .= '					<div class="afs-Tabs col-xs-12">';
			$text .= '						<ul class="afs-CommonTabs ">';
			$text .= '							<li class="active"><a rel="'.$all_filter.'" href="#">All</a></li>';

												$terms = get_terms($taxonomy, $args = array('orderby'=>'id')	);
												if($terms) {
                                                    foreach($terms as $term) {
                                                        if(in_array($term->slug, $filter_by_array)){
														    if(isset($filter_type_array)) {
														    	if(in_array($term->slug,$filter_type_array)) {
														    		if($term->name == 'Uncategorized') { continue; }
														    		$text .= '<li class="'.$term->slug.'" ><a rel="'.$term->slug.'" href="#">'.$term->name.'</a></li>';
														    	}
														    } else {
														    	if($term->name == 'Uncategorized') { continue; }
														    	$text .= '<li class="'.$term->slug.'"><a rel="'.$term->slug.'" href="#">'.$term->name.'</a></li>';
                                                            }
                                                        }
													}
												}

			$text .= '						<input type="hidden" name="filingType" />';
			$text .= '						</ul> <!-- .afs-CommonTabs -->';

			$text .= '					</div> <!--Close afs-Tabs--> ';
		}
 	}


/****************************
	Template Footer
	****************************/
    $text .= '        	</div>';
    $text .= '    	</form>';
	$text .= '	</div>';
	$text .= '</div>';
	$text .= '</div>';
	$text .= '		</div><!-- .grid-full -->';
	$text .= '	</div><!-- .row -->';
	$text .= '		</section><!-- .container -->';
	$text .= '	</main><!-- .hero role = main -->';


	$text .= '		<div class="row">';
    $text .= '           <div class="grid-full ">';

	$text .= '<section class="container">';
	$text .= '		<div class="row">';
    $text .= '           <div class="grid-full ">';

	/****************************
	Begin Feed Area
	****************************/
	$text .= '				<div class="clearfix"></div>';
	$text .= '				<div class="afs-Panel afs-Panel_all col-xs-12" hidden="true">';
	$text .= '					<div id="newsPanel" class="scroll">';
	$text .= '						<div class="afs-TableWrapper" style="display: block;">';
	$text .= '							<div class="row">';

	$text .= '								<div class="afs-Table col-xs-12" style="padding-left:0; padding-right:0;">';
	#$text .= '									<div class="afs-TableHeader col-sm-12 hidden-xs" style="padding-left: 0; padding-right: 0;">';
	#$text .= '										<div class="col-xs-2">Date</div>';
	#$text .= '										<div class="col-xs-10">Headline</div>';
	#$text .= '									</div>';
	$text .= '									<div class="clearfix"></div>';


	/****************************
	Get The Feed
    ****************************/
	$text .= '									<div id="newsPanelResults" class="jscroll-inner">';
	$text .= '										[afs_feed '.$afs_args.']'; // <-- the shortcode
	$text .= '										<div class="clearfix"></div>';
	$text .= '									</div>';
	$text .= '									<div class="clearfix"></div>';
	$text .= '								</div>';

	/****************************
	Close Feed Area
	****************************/
	$text .= '								<div class="clearfix"></div>';
	$text .= '							</div>';
	$text .= '						</div>';
	$text .= '					</div>';
	$text .= '				</div>';
	$text .= '				<div class="clearfix"></div>';

	$text .= '		</div><!-- .grid-full -->';
	$text .= '	</div><!-- .row -->';

    /**************************
        Loading Screen
    ****************************/
    $text .= '		<div class="row">';
    $text .= '           <div class="grid-full ">';
    $text .= '				<div class="afs-Panel-loading col-xs-12" style="height:70vh">';
    $text .= '                  <h3>Loading...</h3>';
	$text .= '				</div>';
	$text .= '				<div class="clearfix"></div>';

	$text .= '		    </div><!-- .grid-full -->';
	$text .= '	    </div><!-- .row -->';
	$text .= '			</div><!-- .grid-full -->';
	$text .= '		</div><!-- .row -->';
	$text .= '</section><!-- .container -->';

	return do_shortcode($text);

}

add_shortcode("ajax_filter_search", "ajax_filter_search");


// [afs_feed]
function afs_feed($atts, $content = null) {
    extract(shortcode_atts(array(
		'post_type'				=> AFSAdmin::afs_retrieve('_general_post_type'),
		'post_tax' 				=> AFSAdmin::afs_retrieve('_general_post_taxonomy'),
		'posts_per_page'		=> AFSAdmin::afs_retrieve('_general_posts_per_page'),
		'filter_type' 			=> '',
		'filter_by' 				=> '',
		'filter_months' 			=> '',
		'filter_years' 			=> '',
		'filter_withPDF' 		=> '',
		'offset' 				=> 0,
        'filter_tabs'           => '',
        'all_filter'            => 'all',
    ), $atts));

	$text = '';
	$i = 1;

	define('FILTER_TYPE', $filter_type);

	/****************************
	Define The Args & Defaults
	****************************/

	$offset_pag = $offset;
	if($filter_type == 'all' ) { $filter_type = ''; }
	if($offset != 0) {  $offset = ($offset - 1) * $posts_per_page; }
	if($posts_per_page == '') { get_option( 'posts_per_page' ); }

	$args = array(
		'post_type'			=> $post_type,
		'posts_per_page' 	=> $posts_per_page,
		'offset'				=> $offset,
		'date_query' 		=> array(array()),
		'orderby' 			=> 'date',
		'order'   			=> 'DESC',
	);

	if($filter_by !== '') { $args['s'] = $filter_by; }
	if($filter_years !== '') { $args['date_query'][]['year'] = $filter_years; }
	if($filter_months !== '') { $args['date_query'][]['month'] = $filter_months; }
	if($post_tax == 'none' || $post_tax == '') {
		// do nothing
	} else {
		if($post_tax == 'category') {
			$args['category_name'] = $filter_type;
		} elseif($post_tax == 'post_tag') {
			$args['tag'] = $filter_type;
		} else {
			// It's a custom post type:
			if($filter_type !== '') {

				$filter_type = explode(',',$filter_type);
				$tax_array = array(
								'taxonomy' => $post_tax,
								'field' => 'slug',
								'terms' => $filter_type,
							);
				$args['tax_query'][] = $tax_array;
			}


		}
	}

	$query = new WP_Query($args);

	if ( $query->have_posts() ) {

		$total_count 			= $query->found_posts;
		//$current_page_number   	= get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;

		if($offset == 0) {
			$current_page_number = 1;
		} else {
			$current_page_number = $offset;
		}

		//$posts_pp  				= get_option( 'posts_per_page' );
		$posts_pp  				= $posts_per_page;
		$posts_per_page 		= $current_page_number * $posts_pp;

		//$current_post_position = ($posts_per_page - $posts_pp) + 1;
		$current_post_position = $offset + 1;

		if($posts_per_page > $total_count) { $posts_per_page = $total_count; }

		$n = 1;
		$mar = 'margin-left:0;';
		while ( $query->have_posts() ) { $query->the_post();

			$i++;
			$n++;
			$text .= '<article class="excerpt article-thumbnail">';
			$text .= '<header>';
            $text .= '<a href="' . get_the_permalink() . '" class="post-thumbnail-container">';
            $text .= get_the_post_thumbnail(get_post(), 'large', array( 'class' => 'post-thumbnail' ));
            $text .= '</a>';
			$text .= '<h2 id="post-' . get_the_ID() . '" class="entry_title"><a href="' . get_the_permalink() . '">' . get_the_title() . '</a></h2>';
			$text .= '</header>';

			$text .= '<div class="entry">';
			$text .= '<div class="hide-article-excerpt">' .  get_the_excerpt() .'</div>';

			$text .= '<div class="author">';
			$text .= get_avatar( get_the_author_meta('user_email'), $size = '50');
            $text .= '<em>Written by ' . get_the_author() . '</em>';
			$text .= '</div><!-- .author -->';
			$text .= '</div><!-- .entry -->';
			$text .= '</article><!-- .excerpt -->';

		}

			// Pagination
	$text .= '<div id="afs-wrapper">';
			$text .= '<div class="row">';
			$text .= '	<div class="col-xs-12">';
			$text .= '		Displaying '.$current_post_position.' to <span id="pageLastRecord">'.$posts_per_page.'</span> (of <span id="recordCount">'.$total_count.'</span>)';
			$text .= '	</div>';
			$text .= '	<div class="clearfix"></div>';
			$text .= '</div>';

			$text .= '<div class="row">';
			$text .= '	 <div class="col-md-12">';
			$text .= 		afs_page_navi( array('echo' => false, 'custom_query' => $query, 'offset' => $offset_pag));
			$text .= '	</div>';
			$text .= '</div>';
			$text .= '</div>';

	} else {

		$text .= 'No data found...';

	}

	wp_reset_query();

	return $text;

}

add_shortcode("afs_feed", "afs_feed");

?>

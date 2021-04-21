/*!
 * dashboard-block.js
 *
 * Copyright (c) 2010 - 2018 "kento" Karim Rahimpur www.itthinx.com
 *
 * This code is released under the GNU General Public License.
 * See COPYRIGHT.txt and LICENSE.txt.
 *
 * This code is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * This header and all notices must be kept intact.
 *
 * @author Karim Rahimpur
 * @package affiliates
 * @since affiliates 4.0.0
 */

if ( typeof wp !== 'undefined' ) {

	// Set the icon for the affiliates block category.
	wp.blocks.updateCategory(
		'affiliates',
		{
			icon : wp.element.createElement(
				'img',
				{
					src    : affiliates_dashboard_block.affiliates_icon,
					width  : 20,
					height : 20
				}
			)
		}
	);

	//
	// The Affiliates Dashboard Profile block.
	// This also uses the ServerSideRender to "preview" the block in the editor. If the viewer is not an affiliate,
	// we render a notice. This avoids the spinner bug (never goes away when content is empty in blocks preview).
	//
	wp.blocks.registerBlockType(
		'affiliates/dashboard',
		{
			title       : affiliates_dashboard_block.title,
			description : affiliates_dashboard_block.description,
			icon        : 'performance',
			category    : 'affiliates',
			keywords    : [ affiliates_dashboard_block.keyword_affiliates, affiliates_dashboard_block.keyword_dashboard ],
			supports    : { html : false },
			attributes  : {
				header_tag : {
					type : 'string'
				},
				content_tag : {
					type : 'string'
				},
				content : {
					type : 'string'
				}
			},
			// Add some inspector controls, use ServerSideRender to preview the block.
			edit : function( props ) {
				var header_tag = props.attributes.header_tag || 'h2',
					content_tag = props.attributes.content_tag || 'p',
					fields = [
						// render the content via our PHP callback
						wp.element.createElement(
							wp.components.ServerSideRender,
							{
								block : 'affiliates/dashboard',
								attributes : props.attributes
							}
						),
						wp.element.createElement(
							'div',
							{
								style : {
									color: '#999',
									padding: '1em',
									backgroundColor : '#eee'
								}
							},
							affiliates_dashboard_block.dashboard_notice
						)
					];
				return fields;
			},
			// It's rendered via our PHP callback so this returns simply null.
			save : function( props ) {
				return null;
			}
		}
	);

}

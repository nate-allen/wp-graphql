<?php

namespace WPGraphQL\Model;


use GraphQLRelay\Relay;

/**
 * Class MenuItem - Models the data for the MenuItem object type
 *
 * @property string   $id
 * @property array    $cassClasses
 * @property string   $description
 * @property string   $label
 * @property string   $linkRelationship
 * @property int      $menuItemId
 * @property string   $target
 * @property string   $title
 * @property string   $url
 * @property \WP_Post $menu
 *
 * @package WPGraphQL\Model
 */
class MenuItem extends Model {

	/**
	 * Stores the incoming post data
	 *
	 * @var \WP_Post $post
	 * @access protected
	 */
	protected $post;

	/**
	 * Stores the fields for the object
	 *
	 * @var array $fields
	 * @access protected
	 */
	protected $fields;

	/**
	 * MenuItem constructor.
	 *
	 * @param \WP_Post $post The incoming WP_Post object that needs modeling
	 *
	 * @access public
	 * @return void
	 * @throws \Exception
	 */
	public function __construct( \WP_Post $post ) {
		$this->post = $post;
		parent::__construct( 'menuItem', $post );
		$this->init();
	}

	/**
	 * Initialize the Post object
	 *
	 * @access public
	 * @return void
	 */
	public function init() {

		if ( empty( $fields ) ) {
			$this->fields = [
				'id' => function() {
					return ! empty( $this->post->ID ) ? Relay::toGlobalId( 'nav_menu_item', $this->post->ID ) : null;
				},
				'cassClasses' => function() {
					// If all we have is a non-array or an array with one empty
					// string, return an empty array.
					if ( ! isset( $this->post->classes ) || ! is_array( $this->post->classes ) || empty( $this->post->classes ) || empty( $this->menu_item->classes[0] ) ) {
						return [];
					}

					return $this->menu_item->classes;
				},
				'description' => function() {
					return ( ! empty( $this->post->description ) ) ? $this->post->description : null;
				},
				'label' => function() {
					return ( ! empty( $this->post->title ) ) ? $this->post->title : null;
				},
				'linkRelationship' => function() {
					return ! empty( $this->post->xfn ) ? $this->post->xfn : null;
				},
				'menuItemId' => function() {
					return absint( $this->post->ID );
				},
				'target' => function() {
					return ! empty( $this->post->target ) ? $this->post->target : null;
				},
				'title' => function() {
					return ( ! empty( $this->post->attr_title ) ) ? $this->post->attr_title : null;
				},
				'url' => function() {
					return ! empty( $this->post->url ) ? $this->post->url : null;
				},
			];

			if ( ! empty( $this->post->menu ) ) {
				$this->fields['menu'] = function() {
					$this->post->menu;
				};
			}

			parent::prepare_fields();

		}

	}

}
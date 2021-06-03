<?php

namespace ElementorIdeaspace\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

// Security Note: Blocks direct access to the plugin PHP files.
defined( 'ABSPATH' ) || die();

/**
 * Awesomesauce widget class.
 *
 * @since 1.0.0
 */
class Ideaspace_Twitter_Feed extends Widget_Base {
	/**
	 * Class constructor.
	 *
	 * @param array $data Widget data.
	 * @param array $args Widget arguments.
	 */
	public function __construct( $data = array(), $args = null ) {
		parent::__construct( $data, $args );

		wp_register_style( 'style', plugins_url( '/108-twitter-addon/assets/css/style.css' ), array(), '1.0.0' );
		wp_register_style( 'bootstrap_css', 'https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css' );
		wp_enqueue_style( 'bootstrap_css' );
		wp_register_script( 'bootstrap_js', 'https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js', null, null, true );
		wp_enqueue_script( 'bootstrap_js' );
		wp_register_script( 'popper_js', 'https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js', null, null, true );
		wp_enqueue_script( 'popper_js' );
		add_action('elementor/editor/before_enqueue_scripts',  wp_enqueue_style( 'style', plugins_url( '/108-twitter-addon/assets/css/style.css' )));
	}

	/**
	 * Retrieve the widget name.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'twitter-feed';
	}

	/**
	 * Retrieve the widget title.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( 'Twitter Feed', 'ideaspace-twitter-widget' );
	}

	/**
	 * Retrieve the widget icon.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'fab fa-twitter';
	}

	/**
	 * Retrieve the list of categories the widget belongs to.
	 *
	 * Used to determine where to display the widget in the editor.
	 *
	 * Note that currently Elementor supports only one category.
	 * When multiple categories passed, Elementor uses the first one.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return array( 'general' );
	}


	public function get_custom_help_url()
    {
        return 'https://www.108ideaspace.com/';
    }

	public function get_keywords()
    {
        return [
            'twitter',
            'twitter feed',
            'twitter gallery',
            'social media',
            'twitter embed',
            'twitter feed',
            'twitter marketing',
            'tweet feed',
            'tweet embed',
        ];
    }
	
	/**
	 * Enqueue styles.
	 */
	public function get_style_depends() {
		return array( 'style' );
	}

	/**
	 * Register the widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 1.0.0
	 *
	 * @access protected
	 */
	protected function _register_controls() {
		$this->start_controls_section(
			'twitter_acc_setting',
			[
				'label' => esc_html__( 'Twitter Account Setting', 'ideaspace-twitter-widget' ),
			]
		);

		$this->add_control(
			'twitter_user_name',
			[
				'label'   => esc_html__( 'User Name', 'ideaspace-twitter-widget' ),
				'type' 	  => Controls_Manager::TEXT,
				'dynamic' => [ 'active' => true ],
				'default' => '@108ideaspace',
				'label_block' => false,
				'description' => esc_html__('Please enter user name with @ sign.', 'ideaspace-twitter-widget'),
			]
		);

		$this->add_control(
            'twitter_consumer_key',
            [
                'label' => esc_html__('Twitter Consumer Key', 'ideaspace-twitter-widget'),
                'type' => Controls_Manager::TEXT,
                'label_block' => false,
                'default' => 'wwC72W809xRKd9ySwUzXzjkmS',
                'description' => '<a href="https://apps.twitter.com/app/" target="_blank">Get Twitter Consumer Key.</a> Create a new app or select existing app and grab the <b>Twitter consumer key.</b>',
            ]
        );

        $this->add_control(
            'twitter_consumer_secret',
            [
                'label' => esc_html__('Twitter Consumer Secret', 'ideaspace-twitter-widget'),
                'type' => Controls_Manager::TEXT,
                'label_block' => false,
                'default' => 'rn54hBqxjve2CWOtZqwJigT3F5OEvrriK2XAcqoQVohzr2UA8h',
                'description' => '<a href="https://apps.twitter.com/app/" target="_blank">Get Twitter Consumer Secret.</a> Create a new app or select existing app and grab the <b>Twitter consumer secret.</b>',
            ]
        );

		$this->end_controls_section();

        $this->start_controls_section(
			'twitter_feed_layout',
			[
				'label' => esc_html__( 'Layout Setting', 'ideaspace-twitter-widget' ),
			]
		);

		$this->add_control(
            'twitter_feed_layout_type',
            [
                'label' => esc_html__('Tweet Layout', 'ideaspace-twitter-widget'),
                'type' => Controls_Manager::SELECT,
                'default' => 'masonry',
                'options' => [
                    'list' => esc_html__('List', 'ideaspace-twitter-widget'),
                    'masonry' => esc_html__('Masonry', 'ideaspace-twitter-widget'),
                ],
            ]
        );

        $this->add_control(
            'twitter_feed_col',
            [
                'label' => __('Column Grid', 'ideaspace-twitter-widget'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    '6' => '2 Columns',
                    '4' => '3 Columns',
                    '3' => '4 Columns',
                ],
                'default' => '6',
                'condition' => [
                    'twitter_feed_layout_type' => 'masonry',
                ],
            ]
        );

		$this->add_control(
            'twitter_feed_limit',
            [
                'label' => esc_html__('Tweet Limit', 'ideaspace-twitter-widget'),
                'type' => Controls_Manager::NUMBER,
                'label_block' => false,
                'min' => 1,
                'default' => 10,
            ]
        );

		$this->add_control(
            'twitter_feed_content_length',
            [
                'label' => esc_html__('Content Length', 'ideaspace-twitter-widget'),
                'type' => Controls_Manager::NUMBER,
                'label_block' => false,
                'min' => 1,
                'max' => 400,
                'default' => 200,
            ]
        );

        $this->add_control(
            'twitter_feed_media',
            [
                'label' => esc_html__('Show Media', 'ideaspace-twitter-widget'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'ideaspace-twitter-widget'),
                'label_off' => __('No', 'ideaspace-twitter-widget'),
                'default' => 'true',
                'return_value' => 'true',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'twitter_feed_show_hide_settings',
            [
                'label' => esc_html__('Show/Hide Settings', 'ideaspace-twitter-widget'),
            ]
        );

        $this->add_control(
            'twitter_feed_show_profile_image',
            [
                'label' => esc_html__('Profile Image', 'ideaspace-twitter-widget'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'ideaspace-twitter-widget'),
                'label_off' => __('No', 'ideaspace-twitter-widget'),
                'default' => 'true',
                'return_value' => 'true',
            ]
        );

        $this->add_control(
            'twitter_feed_show_date',
            [
                'label' => esc_html__('Tweet Date', 'ideaspace-twitter-widget'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'ideaspace-twitter-widget'),
                'label_off' => __('No', 'ideaspace-twitter-widget'),
                'default' => 'true',
                'return_value' => 'true',
            ]
        );

        $this->add_control(
            'twitter_feed_show_read_more',
            [
                'label' => esc_html__('Read More', 'ideaspace-twitter-widget'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'ideaspace-twitter-widget'),
                'label_off' => __('No', 'ideaspace-twitter-widget'),
                'default' => 'true',
                'return_value' => 'true',
            ]
        );

        $this->add_control(
            'twitter_feed_show_twitter_icon',
            [
                'label' => esc_html__('Twitter Icon', 'ideaspace-twitter-widget'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'ideaspace-twitter-widget'),
                'label_off' => __('No', 'ideaspace-twitter-widget'),
                'default' => 'true',
                'return_value' => 'true',
            ]
        );

        $this->end_controls_section();

        /**
         * -------------------------------------------
         * Tab Style (Twitter Feed Card Style)
         * -------------------------------------------
         */
        $this->start_controls_section(
            'twitter_feed_style',
            [
                'label' => esc_html__('Twitter Feed Style', 'ideaspace-twitter-widget'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'twitter_feed_bg',
            [
                'label' => esc_html__('Background Color', 'ideaspace-twitter-widget'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .twitter-feeds' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'twitter_feed_hover_bg',
            [
                'label' => esc_html__('Background Hover Color', 'ideaspace-twitter-widget'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .twitter-feeds:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'twitter_feed_card_padding',
            [
                'label' => esc_html__('Column Padding', 'ideaspace-twitter-widget'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .twitter-feeds-card' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'top' => '10',
                    'right' => '10',
                    'bottom' => '10',
                    'left' => '10',
                    'unit' => 'px',
                    'isLinked' => true,
                ],
                'condition' => [
                    'twitter_feed_layout_type' => 'masonry',
                ],
            ]
        );

        $this->add_responsive_control(
            'twitter_feed_container_padding',
            [
                'label' => esc_html__('Padding', 'ideaspace-twitter-widget'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .twitter-feeds' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'top' => '10',
                    'right' => '10',
                    'bottom' => '10',
                    'left' => '10',
                    'unit' => 'px',
                    'isLinked' => true,
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => '108_twitter_feed_border',
                'label' => esc_html__('Border', 'ideaspace-twitter-widget'),
                'selector' => '{{WRAPPER}} .twitter-feeds',
            ]
        );

        $this->add_control(
            'twitter_feed_border_radius',
            [
                'label' => esc_html__('Border Radius', 'ideaspace-twitter-widget'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 500,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .twitter-feeds' => 'border-radius: {{SIZE}}px;',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'twitter_feed_shadow',
                'label' => __('Box Shadow', 'ideaspace-twitter-widget'),
                'selector' => '{{WRAPPER}} .twitter-feeds',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'twitter_feed_style_typography',
            [
                'label' => esc_html__('Style & Typography', 'ideaspace-twitter-widget'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'twitter_feed_icon_size',
            [
                'label' => __('Twitter Icon Font Size', 'ideaspace-twitter-widget'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 5,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .twitter-icon' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        /*$this->add_control(
            'eael_section_twitter_feed_icon_color',
            [
                'label' => __('Twitter Icon Color', 'ideaspace-twitter-widget'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'scheme' => [
                    'type' => \Elementor\Scheme_Color::get_type(),
                    'value' => \Elementor\Scheme_Color::COLOR_1,
                ],
                'selectors' => [
                    '{{WRAPPER}} .twitter-icon' => 'color: {{VALUE}}',
                ],
            ]
        );*/

        $this->add_control(
            'twitter_icon_color',
            [
                'label' => esc_html__('Twitter Icon Color', 'ideaspace-twitter-widget'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .twitter-icon' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'twitter_icon_hover_color',
            [
                'label' => esc_html__('Twitter Icon Hover Color', 'ideaspace-twitter-widget'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .twitter-icon:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'twitter_feed_title',
            [
                'label' => esc_html__('Title Style', 'ideaspace-twitter-widget'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'twitter_feed_title_color',
            [
                'label' => esc_html__('Color', 'ideaspace-twitter-widget'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .twitter-feed-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'twitter_feed_title_hover_color',
            [
                'label' => esc_html__('Hover Color', 'ideaspace-twitter-widget'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .twitter-feed-title:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'twitter_feed_title_typography',
                'selector' => '{{WRAPPER}} .twitter-feed-title',
            ]
        );

        $this->add_control(
            'twitter_feed_date',
            [
                'label' => esc_html__('Date Style', 'ideaspace-twitter-widget'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'twitter_feed_date_color',
            [
                'label' => esc_html__('Color', 'ideaspace-twitter-widget'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .twitter-feed-date' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'twitter_feed_date_hover_color',
            [
                'label' => esc_html__('Hover Color', 'ideaspace-twitter-widget'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .twitter-feed-date:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'twitter_feed_date_typography',
                'selector' => '{{WRAPPER}} .twitter-feed-date',
            ]
        );

        $this->add_control(
            '108_twitter_feed_content',
            [
                'label' => esc_html__('Content Style', 'ideaspace-twitter-widget'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'twitter_feed_content_color',
            [
                'label' => esc_html__('Color', 'ideaspace-twitter-widget'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .twitter-feed-content' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'twitter_feed_content_hover_color',
            [
                'label' => esc_html__('Hover Color', 'ideaspace-twitter-widget'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .twitter-feed-content:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'twitter_feed_content_typography',
                'selector' => '{{WRAPPER}} .twitter-feed-content',
            ]
        );

        $this->add_control(
            'twitter_feed_read_more',
            [
                'label' => esc_html__('Read More Style', 'ideaspace-twitter-widget'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'twitter_feed_read_more_color',
            [
                'label' => esc_html__('Color', 'ideaspace-twitter-widget'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .twitter-feed-read-more' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'twitter_feed_read_more_hover_color',
            [
                'label' => esc_html__('Hover Color', 'ideaspace-twitter-widget'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .twitter-feed-read-more:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'twitter_feed_read_more_typography',
                'selector' => '{{WRAPPER}} .twitter-feed-read-more',
            ]
        );

        $this->end_controls_section();

         /**
         * -------------------------------------------
         * Tab Style (Company Logo style)
         * -------------------------------------------
         */
        $this->start_controls_section(
            'twitter_feed_avatar',
            [
                'label' => esc_html__('Avatar', 'ideaspace-twitter-widget'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'twitter_feed_show_profile_image' => 'true',
                ],
            ]
        );

        $this->add_control(
            'twitter_feed_avatar_width',
            [
                'label' => __('Width', 'ideaspace-twitter-widget'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 5,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 38,
                ],
                'selectors' => [
                    '{{WRAPPER}} .twitter-feed-avatar img' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'twitter_feed_avatar_height',
            [
                'label' => __('Height', 'ideaspace-twitter-widget'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 5,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .twitter-feed-avatar img' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'twitter_feed_avatar_shape',
            [
                'label' => __('Avatar Shape', 'ideaspace-twitter-widget'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'circle' => 'Circle',
                    'square' => 'Square',
                ],
                'default' => 'circle',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'twitter_feed_avatar_border',
                'label' => __('Border', 'ideaspace-twitter-widget'),
                'selector' => '{{WRAPPER}} .twitter-feed-avatar img',
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'twitter_feed_avatar_shadow',
                'label' => __('Box Shadow', 'ideaspace-twitter-widget'),
                'selector' => '{{WRAPPER}} .twitter-feed-avatar img',
            ]
        );

        $this->end_controls_section();


	}

	/**
	 * Render the widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 *
	 * @access protected
	 */

	protected function render() {
		$settings = $this->get_settings_for_display();

		if ( empty( $settings['twitter_consumer_key'] ) || empty( $settings['twitter_consumer_secret'] ) ){
            return;
        }
			$credentials = base64_encode( $settings['twitter_consumer_key'] . ':' . $settings['twitter_consumer_secret'] );

			$response = wp_remote_post( 'https://api.twitter.com/oauth2/token', [
		                    'method' => 'POST',
		                    'httpversion' => '1.1',
		                    'blocking' => true,
		                    'headers' => [
		                        'Authorization' => 'Basic ' . $credentials,
		                        'Content-Type' => 'application/x-www-form-urlencoded;charset=UTF-8',
		                    ],
		                    'body' => ['grant_type' => 'client_credentials'],
		                ]);
			$body = json_decode( wp_remote_retrieve_body( $response ) );
			if ( $body ){  
	            $token = $body->access_token;
	        }

	        $args = array(
                'httpversion' => '1.1',
                'blocking' => true,
                'headers' => array(
                    'Authorization' => "Bearer " . $token,
                ),
            );

            $response = wp_remote_get( 'https://api.twitter.com/1.1/statuses/user_timeline.json?screen_name=' . $settings['twitter_user_name'] . '&count=999&tweet_mode=extended', [
                'httpversion' => '1.1',
                'blocking' => true,
                'headers' => [
                    'Authorization' => "Bearer " . $token,
                ],
            ]);

            if ( !is_wp_error( $response ) ) {
                $tweets = json_decode( wp_remote_retrieve_body( $response ), true );
            }

            if ( empty( $tweets ) ) {
	            return;
	        }

        	$tweets = array_splice( $tweets, 0, $settings['twitter_feed_limit'] );
        	/*echo '<pre>';
        	print_r($tweets);*/
		if( $settings['twitter_user_name'] == true ):?>
		<div class="row">
		<?php foreach( $tweets as $tweet ): 
			$delimeter = ( strlen($tweet['full_text']) > $settings['twitter_feed_content_length'] ) ? '...' : '';
			$list_col = ( $settings['twitter_feed_layout_type'] == 'masonry' ) ? 'col-md-' . $settings['twitter_feed_col'] : 'col-md-12';
			?>
			<div class="<?php echo $list_col;?> mb-4 twitter-feeds-card">
			<div class="twitter-feeds" style="height: 100%;">
			<!--div class="d-flex"-->
			<?php if( $settings['twitter_feed_show_profile_image'] == true ): ?>
				<a href="https://twitter.com/<?php echo $settings['twitter_user_name'];?>" class="twitter-feed-avatar shape-<?php echo $settings['twitter_feed_avatar_shape'];?>"><img src="<?php echo $tweet['user']['profile_image_url_https'];?>"></a>
			<?php endif;?>

				<a href="https://twitter.com/<?php echo $settings['twitter_user_name'];?>" target="_blank" class="align-middle"><?php echo ( $settings['twitter_feed_show_twitter_icon'] == true ) ? '<i class="fab fa-twitter twitter-icon"></i> ' : '';?><span class="twitter-feed-title"><?php echo $tweet['user']['name'];?></span></a>
			<?php if( $settings['twitter_feed_show_date'] == true ): 
				$tweet_date_4 = ( $settings['twitter_feed_col'] == 3 ) ? 'padding-top:0;' : '';?>
				<span class="tweet-feed-date float-right" style="<?php echo $tweet_date_4;?>"><?php echo sprintf(__( '%s ago', 'ideaspace-twitter-widget' ), human_time_diff( strtotime( $tweet['created_at'] ) ) );?></span>
			<?php endif;?>
			<!--/div-->
				<div class="twitter-feed-content pt-3 pb-2"><?php $text_without_link = isset( $tweet['entities']['urls'][0]['url'] ) ? str_replace($tweet['entities']['urls'][0]['url'], '', $tweet['full_text']) : $tweet['full_text'];
				echo substr( $text_without_link, 0, $settings['twitter_feed_content_length'] ) . $delimeter;?></div>

			<?php if( $settings['twitter_feed_show_read_more'] == true && $delimeter != '' ): ?>
				<a href="<?php echo 'https://twitter.com/' . $tweet['user']['screen_name'] . '/status/' . $tweet['id_str'];?>" target="_blank" class="twitter-feed-read-more"><?php echo __( 'Read More', 'ideaspace-twitter-widget' );?></a>
			<?php endif;?>		

			<?php if( $tweet['retweeted_status']['entities']['media'][0] && $settings['twitter_feed_media'] ) :
					if( $tweet['retweeted_status']['entities']['media'][0]['type'] == 'photo'): ?>
						<img src="<?php echo $tweet['retweeted_status']['entities']['media'][0]['media_url_https'];?>" style="height: 300px; width: 500px;">
					<?php endif;
				endif;?>
			</div>
		</div>
		<?php endforeach;?>
		</div>
		
		<?php
	endif;
	}

	/**
	 * Render the widget output in the editor.
	 *
	 * Written as a Backbone JavaScript template and used to generate the live preview.
	 *
	 * @since 1.0.0
	 *
	 * @access protected
	 */
	/*protected function _content_template() {
		?>
		<div class="twitter-feeds" style="color: {{ settings.twitter_card_bg }}"> .. </div>
		<?php
	}*/
}

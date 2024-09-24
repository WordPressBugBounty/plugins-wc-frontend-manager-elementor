<?php

class WCFM_Elementor_StoreData {

	protected $store_data = [];

	public function get_data( $prop = null ) {
		global $WCFM, $WCFMem;
		if ( $WCFMem->is_edit_or_preview_mode() ) {
			$data = $this->get_store_data_for_editing();
		} else {
			$data = $this->get_store_data();
		}
		return ( $prop && isset( $data[ $prop ] ) ) ? $data[ $prop ] : $data;
	}

	protected function get_store_data() {
		global $WCFM, $WCFMem;
		if ( ! empty( $this->store_data ) ) {
			return $this->store_data;
		}

		$this->store_data = apply_filters( 'wcfmem_elementor_store_data_defaults', [
				'id'              => 0,
				'banner'          => [
						'id'  => 0,
						'url' => $WCFMem->plugin_url . 'assets/images/default-banner.jpg',
				],
				'name'            => '',
				'logo' => [
						'id'  => 0,
						'url' => $WCFMem->plugin_url . 'assets/images/default-logo.png',
				],
				'address'         => '',
				'phone'           => '',
				'email'           => '',
				'rating'          => ''
		] );


		$store      = wcfmmp_get_store( get_query_var( 'author' ) );
		$store_info = $store->get_shop_info();

		if ( $store->id ) {
			$this->store_data['id'] = $store->id;

			$banner_id = (int) $store->get_info_part( 'banner' );

			if ( $banner_id ) {
				$this->store_data['banner'] = [
						'id'  => $banner_id,
						'url'           => $store->get_banner(),
						'banner_type'   => $store->get_banner_type(),
						'banner_slider' => $store->get_banner_slider(),
						'banner_video'  => $store->get_banner_video()
				];
			}

			$this->store_data['name'] = $store->get_shop_name();

			$logo_id = (int) $store->get_info_part( 'gravatar' );

			if ( $logo_id ) {
				$this->store_data['logo'] = [
						'id'  => $logo_id,
						'url' => $store->get_avatar(),
				];
			}

			$address = $store->get_address_string();
			if( $address && ( $store_info['store_hide_address'] == 'no' ) && $WCFM->wcfm_vendor_support->wcfm_vendor_has_capability( $store->get_id(), 'vendor_address' ) ) {
				if ( ! empty( $address ) ) {
					$this->store_data['address'] = $address;
				}
			}

			$phone = $store->get_phone();

			if( $phone && ( $store_info['store_hide_phone'] == 'no' ) && $WCFM->wcfm_vendor_support->wcfm_vendor_has_capability( $store->get_id(), 'vendor_phone' ) ) {
				if ( ! empty( $phone ) ) {
					$this->store_data['phone'] = $phone;
				}
			}

			$email = $store->get_email();
			if( $email && ( $store_info['store_hide_email'] == 'no' ) && $WCFM->wcfm_vendor_support->wcfm_vendor_has_capability( $store->get_id(), 'vendor_email' ) ) {
				if ( ! empty( $email ) ) {
					$this->store_data['email'] = $email;
				}
			}

			$rating = $store->get_avg_review_rating();

			if ( ! empty( $rating ) ) {
				$this->store_data['rating'] = $rating;
			}

			$vendor_has_vacation = $WCFM->wcfm_vendor_support->wcfm_vendor_has_capability( $store->id, 'vacation' );
			$this->store_data['vacation_message'] = '';
			if( $vendor_has_vacation ) {
				$vendor_profile_data = get_user_meta( $store->id, 'wcfmmp_profile_settings', true );
				$vacation_mode = isset( $vendor_profile_data['wcfm_vacation_mode'] ) ? $vendor_profile_data['wcfm_vacation_mode'] : 'no';
				$wcfm_vacation_mode_type = isset( $vendor_profile_data['wcfm_vacation_mode_type'] ) ? $vendor_profile_data['wcfm_vacation_mode_type'] : 'instant';
				$wcfm_vacation_start_date = isset( $vendor_profile_data['wcfm_vacation_start_date'] ) ? $vendor_profile_data['wcfm_vacation_start_date'] : '';
				$wcfm_vacation_end_date = isset( $vendor_profile_data['wcfm_vacation_end_date'] ) ? $vendor_profile_data['wcfm_vacation_end_date'] : '';
				$vacation_msg = wcfm_get_user_meta( $store->id, '_wcfm_vacation_msg', true );
				$vacation_msg = apply_filters( 'wcfm_vacation_message_text', $vacation_msg );

				if ( $vacation_mode == 'yes' ) {
					if( $wcfm_vacation_mode_type == 'instant' ) {
						$this->store_data['vacation_message'] = $vacation_msg;
					}
				  elseif( $wcfm_vacation_start_date && $wcfm_vacation_end_date ) {
						
						$current_time = strtotime( 'midnight', current_time( 'timestamp' ) );
						$start_time = strtotime( $wcfm_vacation_start_date );
						$end_time = strtotime( $wcfm_vacation_end_date );
						if( ($current_time >= $start_time) && ($current_time <= $end_time) ) {
							
							$this->store_data['vacation_message'] = $vacation_msg;
						}
					}
				}
			}

			$this->store_data = apply_filters( 'wcfmem_elementor_store_data', $this->store_data );
		}

		return $this->store_data;
	}

	/**
	 * Data for editing/previewing purpose
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	protected function get_store_data_for_editing() {
		global $WCFM, $WCFMem;
		return apply_filters( 'wcfmem_elementor_store_data_defaults_for_editing', [
				'id'              => 0,
				'banner'          => [
						'id'  => 0,
						'url' => $WCFMem->plugin_url . 'assets/images/default-banner.jpg',
				],
				'name'            => 'Store Name',
				'logo' => [
						'id'  => 0,
						'url' => $WCFMem->plugin_url . 'assets/images/default-logo.png',
				],
				'address'         => 'Kolkata, India (IN)',
				'phone'           => '999-999-9999',
				'email'           => 'demo@store.com',
				'rating'          => '5 rating from 50 reviews',
		] );
	}
}

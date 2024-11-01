<?php 

if ( ! class_exists( 'WP_List_Table' ) ) {
    require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}

class TDPRB_Orders_List_Table extends WP_List_Table {
    
    private $order_statuses;
    private $per_page;

    /**
     * Initialize the class and set its properties.
     */
    public function __construct() {
        parent::__construct( array(
            'singular' => __( 'Order List', 'tdp-ring-builder' ), // Singular name of the listed records
            'plural'   => __( 'Orders List', 'tdp-ring-builder' ), // Plural name of the listed records
            'ajax'     => false // Does this table support ajax?
        ) );

        // Define order statuses and items per page
        $this->order_statuses = array(
            'wc-pending',
            'wc-processing',
            'wc-on-hold',
            'wc-completed',
            'wc-cancelled',
            'wc-refunded',
            'wc-failed',
        );

        $this->per_page = 10; // Define items per page
    }

    /**
     * Prepare Items
     *
     * @return void
     */
    public function prepare_items() {

        $columns  = $this->get_columns();
        $this->_column_headers = array( $columns );
        $order_query_args = array(
			'limit'    => $this->per_page,
			'page'     => $this->get_pagenum(),
			'paginate' => true,
			'type'     => 'shop_order',
            'status'   => $this->order_statuses,
            'meta_query' => array(
                array(
                    'key'     => '_thankyou_action_done',
                    'value'   => 1,
                    'compare' => '=', // Compare the meta key's value to '1'
                ),
            ),
		);

        $orders      = wc_get_orders( $order_query_args );
		$this->items = $orders->orders;
        
		$max_num_pages = $orders->max_num_pages;
        
        // Check in case the user has attempted to page beyond the available range of orders.
		if ( 0 === $max_num_pages && $order_query_args['page'] > 1 ) {
           
			$count_query_args          = $order_query_args;
			$count_query_args['page']  = 1;
			$count_query_args['limit'] = 1;
			$order_count               = wc_get_orders( $count_query_args );
			$max_num_pages             = (int) ceil( $order_count->total / $order_query_args['limit'] );
		}

		$this->set_pagination_args(
			array(
				'total_items' => $orders->total ?? 0,
				'per_page'    => 5,
				'total_pages' => $max_num_pages,
			)
        );

    }
    
    /**
     * Default value of column
     *
     * @param [type] $item
     * @param [type] $column_name
     * @return void
     */
    public function column_default( $item, $column_name ) {
       
        switch ( $column_name ) {
            case 'order_id':
                return $item->get_id();
            case 'order_date':
                return $item->get_date_created()->date( 'Y-m-d H:i:s' );
            case 'order_total':
                return $item->get_total();
            case 'order_status':
                return wc_get_order_status_name( $item->get_status() );
            default:
                return print_r( $item, true ) ; //Show the whole array for troubleshooting purposes
        }
    }

    /**
     * Get Sortable column
     *
     * @return sortable_columns
     */
    function get_sortable_columns() {
        $sortable_columns = array(
          'order_id'  => array('order_id',false),
          'order_date' => array('order_date',false),
          'order_status'   => array('order_status',false)
        );
        return $sortable_columns;
    }

    /**
     * Get columns
     *
     * @return void
     */
    public function get_columns() {
        return array(
            'order_id'    => __( 'Order ID', 'tdp-ring-builder' ),
            'order_date'  => __( 'Order Date', 'tdp-ring-builder' ),
            'order_total' => __( 'Total', 'tdp-ring-builder' ),
            'order_status' => __( 'Status', 'tdp-ring-builder' ),
        );
    }

    /**
     * Renders the settings page
     *
     * Includes the settings page template based on the access token value.
     */
    public function render() {
        ?>
        <div class="wrap">
            <h1 class="tdprb-py-4"><?php esc_html_e( 'Orders', 'tdp-ring-builder' ); ?></h1>
            <?php  $this->prepare_items();  ?>
            <form id="wc-orders-filter" method="get" action="<?php echo esc_url( get_admin_url( null, 'admin.php' ) ); ?>">
                <input type="hidden" name="page" value="ttest_list_table">
                <?php parent::display(); ?>
            </form>
        </div>
    <?php
    }
}
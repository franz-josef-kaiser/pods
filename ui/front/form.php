<?php
    $uri_hash = wp_create_nonce( 'pods_uri_' . $_SERVER[ 'REQUEST_URI' ] );
    $field_hash = wp_create_nonce( 'pods_fields_' . implode( ',', array_keys( $fields ) ) );

    $nonce = wp_create_nonce( 'pods_form_' . $pod->pod . '_' . session_id() . '_' . $pod->id() . '_' . $uri_hash . '_' . $field_hash );

    if ( isset( $_POST[ '_pods_nonce' ] ) ) {
        try {
            $id = $pod->api->process_form( $pod, $fields, $thank_you );
        }
        catch ( Exception $e ) {
            echo '<div class="pods-message pods-message-error">' . $e->getMessage() . '</div>';
        }
    }
?>
<form action="<?php echo pods_var_update( array( '_p_submitted' => 1 ) ); ?>" method="post" class="pods-manage pod-event">
    <?php echo PodsForm::field( '_pods_nonce', $nonce, 'hidden' ); ?>
    <?php echo PodsForm::field( '_pods_pod', $pod->pod, 'hidden' ); ?>
    <?php echo PodsForm::field( '_pods_id', $pod->id(), 'hidden' ); ?>
    <?php echo PodsForm::field( '_pods_uri', $uri_hash, 'hidden' ); ?>
    <?php echo PodsForm::field( '_pods_form', implode( ',', array_keys( $fields ) ), 'hidden' ); ?>

	<div id="post-body">
		<div id="post-body-content">
			<div class="inside">
				<ul class="form-fields">
                    <?php
                        foreach ( $fields as $field ) {
                    ?>
                        <li class="pods-field <?php echo 'pods-form-ui-row-type-' . $type . ' pods-form-ui-row-name-' . Podsform::clean( $name, true ); ?>">
                            <?php PodsForm::row( $field[ 'name' ], $pod->field( $field[ 'name' ] ), $field[ 'type' ], $field[ 'options' ], $pod, $pod->id() ); ?>
                        </li>
                    <?php
                        }
                    ?>
		        </ul>
            </div>
        </div>
	</div>
</form>
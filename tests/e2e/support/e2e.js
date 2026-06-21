/**
 * Cypress E2E support file.
 *
 * Loaded before every spec file. Registers custom commands
 * for WordPress admin login.
 */

const WP_ADMIN_USER = Cypress.env( 'WP_ADMIN_USER' ) || 'admin';
const WP_ADMIN_PASSWORD = Cypress.env( 'WP_ADMIN_PASSWORD' ) || 'password';

/**
 * Log in to the WordPress admin dashboard.
 */
Cypress.Commands.add( 'wpLogin', ( username = WP_ADMIN_USER, password = WP_ADMIN_PASSWORD ) => {
	cy.request( {
		method: 'POST',
		url: '/wp-login.php',
		form: true,
		body: {
			log: username,
			pwd: password,
			'wp-submit': 'Log In',
			redirect_to: '/wp-admin/',
			testcookie: 1,
		},
	} );
	cy.visit( '/wp-admin/' );
	cy.location( 'pathname' ).should( 'contain', 'wp-admin' );
} );

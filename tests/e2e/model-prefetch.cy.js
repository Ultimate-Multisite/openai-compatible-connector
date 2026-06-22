/**
 * E2E regression tests for connector model prefetch behaviour.
 *
 * Run: npx cypress run --spec tests/e2e/model-prefetch.cy.js
 */

describe( 'Model prefetch regression', () => {
	it( 'reruns model prefetch after provider list changes', () => {
		cy.readFile( 'src/index.jsx' ).then( ( source ) => {
			expect( source ).to.contain( '// Fetch models for all providers once initial settings are loaded.' );
			expect( source ).to.contain( '}, [ isLoading, providers ] );' );
		} );
	} );
} );

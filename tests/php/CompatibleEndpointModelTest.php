<?php
/**
 * Tests for OpenAI-compatible request formatting.
 *
 * @package UltimateAiConnectorCompatibleEndpoints
 * @license GPL-2.0-or-later
 */

declare(strict_types=1);

namespace UltimateAiConnectorCompatibleEndpoints\Tests;

use WP_UnitTestCase;

/**
 * Compatible endpoint model tests.
 */
class CompatibleEndpointModelTest extends WP_UnitTestCase {

	/**
	 * Structured output must use the standard named JSON Schema envelope.
	 */
	public function test_response_format_wraps_json_schema() {
		$parent_class = 'WordPress\\AiClient\\Providers\\OpenAiCompatibleImplementation\\AbstractOpenAiCompatibleTextGenerationModel';
		if ( ! class_exists( $parent_class ) ) {
			$this->markTestSkipped( 'AI Client SDK not available in this test environment.' );
		}

		$model_class = 'UltimateAiConnectorCompatibleEndpoints\\CompatibleEndpointModel';
		$this->assertTrue( class_exists( $model_class ) );

		$schema = [
			'type'       => 'object',
			'properties' => [
				'suggestions' => [ 'type' => 'array' ],
			],
		];

		$reflection = new \ReflectionClass( $model_class );
		$model      = $reflection->newInstanceWithoutConstructor();
		$method     = $reflection->getMethod( 'prepareResponseFormatParam' );
		$method->setAccessible( true );
		$format = $method->invoke( $model, $schema );

		$this->assertSame( 'json_schema', $format['type'] );
		$this->assertSame( 'wordpress_response', $format['json_schema']['name'] );
		$this->assertSame( $schema, $format['json_schema']['schema'] );
	}
}

<?php declare(strict_types=1);

/**
 * @copyright 2019 Christoph Wurst <christoph@winzerhof-wurst.at>
 *
 * @author 2019 Christoph Wurst <christoph@winzerhof-wurst.at>
 *
 * @license GNU AGPL version 3 or any later version
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

namespace OCA\Mail\Tests\Unit\Controller;

use ChristophWurst\Nextcloud\Testing\ServiceMockObject;
use OCA\Mail\Controller\SettingsController;
use OCA\Mail\Tests\Integration\TestCase;
use OCP\AppFramework\Http\JSONResponse;

class SettingsControllerTest extends TestCase {

	/** @var ServiceMockObject */
	private $mock;

	/** @var SettingsController */
	private $controller;

	protected function setUp(): void {
		parent::setUp();

		$this->mock = $this->createServiceMock(SettingsController::class);
		$this->controller = $this->mock->getService();
	}

	public function testProvisioning() {
		$this->mock->getParameter('provisioningManager')
			->expects($this->once())
			->method('newProvisioning')
			->with(
				'%USERID%@domain.com',
				'%USERID%@domain.com',
				'mx.domain.com',
				993,
				'ssl',
				'%USERID%@domain.com',
				'mx.domain.com',
				567,
				'tls'
			);

		$response = $this->controller->provisioning(
			'%USERID%@domain.com',
			'%USERID%@domain.com',
			'mx.domain.com',
			993,
			'ssl',
			'%USERID%@domain.com',
			'mx.domain.com',
			567,
			'tls'
		);

		$this->assertInstanceOf(JSONResponse::class, $response);
	}

	public function testDeprovision() {
		$this->mock->getParameter('provisioningManager')
			->expects($this->once())
			->method('deprovision');

		$response = $this->controller->deprovision();

		$this->assertInstanceOf(JSONResponse::class, $response);
	}
}
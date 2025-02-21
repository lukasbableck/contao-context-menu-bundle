<?php
namespace Lukasbableck\ContaoContextMenuBundle\EventListener;

use Contao\CoreBundle\DependencyInjection\Attribute\AsHook;
use Contao\CoreBundle\Framework\ContaoFramework;

#[AsHook('loadDataContainer', priority: -255)]
class PrimaryOperationsListener {
	public function __construct(private ContaoFramework $framework) {
		$this->framework = $framework;
	}

	public function __invoke(string $table): void {
		foreach ($GLOBALS['TL_DCA'][$table]['list']['operations'] as $key => $operation) {
			$GLOBALS['TL_DCA'][$table]['list']['operations'][$key]['primary'] = true;
		}
	}
}

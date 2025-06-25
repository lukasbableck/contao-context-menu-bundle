<?php
namespace Lukasbableck\ContaoContextMenuBundle\EventListener;

use Contao\CoreBundle\DependencyInjection\Attribute\AsHook;
use Contao\CoreBundle\Routing\ScopeMatcher;
use Contao\StringUtil;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\RequestStack;

#[AsHook('loadDataContainer', priority: -255)]
class PrimaryOperationsListener {
	public function __construct(private readonly RequestStack $requestStack, private readonly ScopeMatcher $scopeMatcher, private readonly Security $security) {
	}

	public function __invoke(string $table): void {
		if (!$this->requestStack->getCurrentRequest() || !$this->scopeMatcher->isBackendRequest()) {
			return;
		}
		$user = $this->security->getUser();
		if ($user === null) {
			return;
		}

		if (!\is_array($GLOBALS['TL_DCA'][$table] ?? null)) {
			return;
		}

		if (!$user->enableContextMenu) {
			foreach ($GLOBALS['TL_DCA'][$table]['list']['operations'] as $key => $operation) {
				$GLOBALS['TL_DCA'][$table]['list']['operations'][$key]['primary'] = true;
			}

			return;
		}

		$alwaysShowOperations = StringUtil::deserialize($user->alwaysShowOperations, true);
		foreach ($GLOBALS['TL_DCA'][$table]['list']['operations'] as $key => $operation) {
			if (\in_array($key, $alwaysShowOperations)) {
				$GLOBALS['TL_DCA'][$table]['list']['operations'][$key]['primary'] = true;
			}
		}
	}
}

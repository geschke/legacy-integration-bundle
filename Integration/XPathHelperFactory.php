<?php
/*
 * (c) webfactory GmbH <info@webfactory.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Webfactory\Bundle\LegacyIntegrationBundle\Integration;

use Webfactory\Dom\BaseParsingHelper;

class XPathHelperFactory
{

    /** @var BaseParsingHelper */
    protected $parser;

    /** @var LegacyApplication */
    protected $legacyApplication;

    public function __construct(BaseParsingHelper $parser, LegacyApplication $legacy)
    {
        $this->parser = $parser;
        $this->legacyApplication = $legacy;
    }

    public function createHelper()
    {
        return new XPathHelper($this->parser, $this->legacyApplication->getResponse()->getContent());
    }
}

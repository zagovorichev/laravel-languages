<?php
/**
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * MIT Public License for more details.
 *
 * Copyright (c) 2016. (original work)
 *
 * @author A.Zagovorichev <zagovorichev@gmail.com>
 */

namespace Zagovorichev\Laravel\Languages\Manager;


class DomainManager extends PathManager
{
    protected function getModeName()
    {
        return 'domain';
    }

    protected function getResource()
    {
        return $this->request->url();
    }

    protected function getRegExp()
    {
        return $this->getConfig()->get('domainRegExp', '');
    }

    protected function separator()
    {
        return $this->getConfig()->get('domainRegExp.separator', '');
    }
}

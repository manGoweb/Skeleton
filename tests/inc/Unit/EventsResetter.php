<?php

namespace Tests\Unit;

use Nette;
use Orm;


/**
 * Zruší listenery na repozitáři
 *
 * @uses Access
 *
 * @author Vojtěch Dobeš
 */
class EventsResetter extends Nette\Object
{

	/**
	 * Nasimuluje odeslání formuláře.
	 *
	 * @param array data, kterými se formulář naplní
	 * @return Nette\Application\IResponse odpověď serveru na odeslání formuláře
	 */
	public function removeListeners(Orm\IRepository $repository)
	{
		$listeners = Access($repository->events, '$listeners');
		$listeners->set(array(
			Orm\Events::HYDRATE_BEFORE => array(),
			Orm\Events::HYDRATE_AFTER => array(),
			Orm\Events::ATTACH => array(),
			Orm\Events::PERSIST_BEFORE => array(),
			Orm\Events::PERSIST_BEFORE_UPDATE => array(),
			Orm\Events::PERSIST_BEFORE_INSERT => array(),
			Orm\Events::PERSIST => array(),
			Orm\Events::PERSIST_AFTER_UPDATE => array(),
			Orm\Events::PERSIST_AFTER_INSERT => array(),
			Orm\Events::PERSIST_AFTER => array(),
			Orm\Events::REMOVE_BEFORE => array(),
			Orm\Events::REMOVE_AFTER => array(),
			Orm\Events::FLUSH_BEFORE => array(),
			Orm\Events::FLUSH_AFTER => array(),
			Orm\Events::CLEAN_BEFORE => array(),
			Orm\Events::CLEAN_AFTER => array(),
			Orm\Events::SERIALIZE_BEFORE => array(),
			Orm\Events::SERIALIZE_AFTER => array(),
			Orm\Events::SERIALIZE_CONVENTIONAL => array(),
		));
	}

}

<?php

namespace App\Models\Tasks;

use App\Models\Services\Mailer;


abstract class SendEmail extends Task
{

	abstract public function run(Mailer $mailer);

}

Configuration
=============

In load order (later overrides former)

<dl>
	<dt>`system`</dt>
		<dd>Low level stuff required for Skeleton. Ideally you should never need to change this.</dd>
	<dt>`bin`</dt>
		<dd>Console commands and services. Services defined here must not be used in app (such service must be moved to config). <b>Only loaded in console mode.</b></dd>
    <dt>`config`</dt>
		<dd>Application level configuration.</dd>
	<dt>`config.local`</dt>
		<dd>Machine level configuration. Must not define new services, only overrides  are allowed.</dd>
</dl>

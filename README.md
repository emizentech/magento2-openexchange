# magento2-OpenExchange

#Features
<ul>
<li>OpenExchange Currency Import Service</li>
</ul>

<h2>Composer Installation Instructions</h2>
Add GIT Repository to composer
<pre>
composer config repositories.emizentech-magento2-openexchange vcs https://github.com/emizentech/magento2-openexchange/
</pre>

After that, need to install this module as follows:
<pre>
  composer require magento/magento-composer-installer
  composer require emizentech/openexchange
</pre>


<br/>
<h2> Mannual Installation Instructions</h2>
go to Magento2Project root dir 
create following Directory Structure :<br/>
<strong>/Magento2Project/app/code/Emizentech/OpenExchange</strong>
you can also create by following command:
<pre>
cd /Magento2Project
mkdir app/code/Emizentech
mkdir app/code/Emizentech/OpenExchange
</pre>



<h3> Enable Emizentech/OpenExchange Module</h3>
to Enable this module you need to follow these steps:

<ul>
<li>
<strong>Enable the Module</strong>
<pre>bin/magento module:enable Emizentech_OpenExchange</pre></li>
<li>
<strong>Run Upgrade Setup</strong>
<pre>bin/magento setup:upgrade</pre></li>
<li>
<strong>Re-Compile (in-case you have compilation enabled)</strong>
	<pre>bin/magento setup:di:compile</pre>
</li>
</ul>


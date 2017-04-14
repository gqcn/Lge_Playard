<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>{$title}</title>
	</head>

    <body>
        {foreach from=$list index=$index key=$key item=$item}
            <div>{$item['uid']}: {$item['name']}</div>
        {/foreach}
        <div>
            {if $test}
                {$a}
            {else}
                2
            {/if}
        </div>
        <div>{include menu}</div>
        <div>{include main}</div>
        <div>{include foot}</div>
        <div>
            <pre>
{$_SERVER}
            </pre>
        </div>

	</body>
</html>

<div id="memorista-settings-container">    
    <?php if ($apiKey == "" || $apiKey == null) { ?>
    <div id="memorista-installation-status">
        Please complete the installation by signing in with your Memorista account.
    </div>
    <?php } ?>
    
    <script type="text/javascript">
        window.addEventListener('message', event => {
            if (event.origin !== 'https://memorista.io') return;

            let apiKey;
            try {
                apiKey = JSON.parse(event.data).apiKey;
            } catch (exc) {
                console.error(exc);
            }
            if (!apiKey) return;

            const container = document.getElementById('memorista-installation-status');

            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '';

            const apiKeyInput = document.createElement('input');
            apiKeyInput.setAttribute('type', 'hidden');
            apiKeyInput.setAttribute('name', 'apiKey');
            apiKeyInput.setAttribute('value', apiKey);

            form.appendChild(apiKeyInput);
            container.appendChild(form);

            form.submit();
        }, false);
    </script>

    <script type="text/javascript">
        const onIframeLoad = iframe => {
            iframe.contentWindow.postMessage(JSON.stringify({
                name: 'wordpress',
                hasCompletedInstallation: !!'<?php echo $apiKey; ?>'
            }), 'https://memorista.io');
        }
    </script>
    <iframe src="https://memorista.io/admin" id="memorista-admin-container" onload="onIframeLoad(this)">
</div>

<div id="memorista-settings-container">    
    <script type="text/javascript">
        let signInWindow = null;

        window.addEventListener('message', event => {
            if (event.origin !== 'https://memorista.io') return;

            let apiKey;
            try {
                apiKey = JSON.parse(event.data).apiKey;
            } catch (exc) {
                console.error(exc);
            }
            if (!apiKey) return;

            const container = document.getElementById('memorista-settings-container');

            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '';

            const apiKeyInput = document.createElement('input');
            apiKeyInput.setAttribute('type', 'hidden');
            apiKeyInput.setAttribute('name', 'apiKey');
            apiKeyInput.setAttribute('value', apiKey);

            form.appendChild(apiKeyInput);
            container.appendChild(form);

            signInWindow.close();
            signInWindow = null;
            form.submit();
        }, false);
    </script>

    <h1>Memorista</h1>
    <p>You are using the latest version of Memorista.</p>

    <?php if ($apiKey == "" || $apiKey == null) { ?>
    <script type="text/javascript">
        const onSignIn = () => {
            if (signInWindow === null || signInWindow.closed) {
                signInWindow = window.open('https://memorista.io/admin', 'SignInWindow', 'menubar=no,width=1024,height=768');

                // TODO: Replace setTimeout workaround with event listener that registers when Memorista Admin UI is ready
                setTimeout(() => {
                    signInWindow.postMessage(JSON.stringify({
                        name: 'wordpress',
                        hasCompletedInstallation: !!'<?php echo $apiKey; ?>'
                    }), 'https://memorista.io');
                }, 1000);
            } else {
                signInWindow.focus();
            }
        }
    </script>
    <h2>Getting Started</h2>
    <p>Before you can start using Memorista, you need to sign in with your Memorista account.</p>
    <button class="button button-primary" onclick="onSignIn();">Sign In</button>
    <?php } else { ?>
    <h2>Manage</h2>
    <p>You can manage all entries and your guestbook settings in the Memorista Admin interface.</p>
    <a href="https://memorista.io/admin" target="_blank" class="button button-primary">Go to Memorista Admin</a>
    <h2>Embed</h2>
    <p>Memorista is ready to be used. Please use the Shortcode <code>[show_memorista]</code> to embed the guestbook on the desired page.</p>
    <table class="form-table" role="presentation">
        <tbody>
            <tr>
                <th scope="row"><label for="shortcode">Shortcode</label></th>
                <td><input name="shortcode" type="text" id="blogname" value="[show_memorista]" class="regular-text" readonly></td>
            </tr>
        </tbody>
    </table>
    <h2>Sign Out</h2>
    <p>To use a different Memorista account, please sign out first.</p>
    <button class="button">Sign Out</button>
    <?php } ?>
</div>

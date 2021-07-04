<script type="text/javascript">
let authorizationWindow = null;

window.addEventListener("message", (event) => {
    if (!event.data) return;
    if (typeof event.data !== "string") return;
    if (!event.data.includes("memorista.approvePluginActivation")) return;

    let apiKey;
    try {
        apiKey = JSON.parse(event.data).apiKey;
    } catch (exc) {
        console.error(exc);
    }
    if (!apiKey) return;

    const container = document.getElementById("memorista-settings-container");

    const form = document.createElement("form");
    form.method = "POST";
    form.action = "";

    const apiKeyInput = document.createElement("input");
    apiKeyInput.setAttribute("type", "hidden");
    apiKeyInput.setAttribute("name", "apiKey");
    apiKeyInput.setAttribute("value", apiKey);

    form.appendChild(apiKeyInput);
    container.appendChild(form);

    authorizationWindow.close();
    authorizationWindow = null;
    form.submit();
}, false);

const authorize = () => {
    if (authorizationWindow === null || authorizationWindow.closed) {
        authorizationWindow = window.open(
            "https://memorista.io/admin/plugin/activate/Wordpress",
            "AuthorizationWindow",
            "menubar=no,width=400,height=600,top=100,left=100"
        );
    } else {
        authorizationWindow.focus();
    }
};
</script>

<div id="memorista-settings-container">
    <h1>Memorista</h1>
    <p>You are using the latest version of Memorista.</p>
    <?php if ($apiKey == "" || $apiKey == null) { ?>
    <h2>Getting Started</h2>
    <p>Before you can start using Memorista, you need to authorize this plugin with your Memorista account.</p>
    <button class="button button-primary" onclick="authorize();">Authorize</button>
    <?php } else { ?>
    <h2>Manage</h2>
    <p>You can manage all entries and your guestbook settings in the Memorista Admin interface.</p>
    <a href="https://memorista.io/admin" target="_blank" class="button button-primary">Go to Memorista Admin</a>
    <h2>Embed</h2>
    <p>Memorista is ready to be used. Please use the shortcode <code>[memorista]</code> to embed the guestbook on the desired page.</p>
    <table class="form-table" role="presentation">
        <tbody>
            <tr>
                <th scope="row"><label for="shortcode">Shortcode</label></th>
                <td><input name="shortcode" type="text" id="blogname" value="[memorista]" class="regular-text" readonly></td>
            </tr>
        </tbody>
    </table>
    <h2>Reset</h2>
    <p>If you want to authorize a different guestbook, you can use the below reset button to revoke your current API key.</p>
    <form method="post">
        <input type="hidden" name="apiKey" value="" />
        <input type="submit" class="button" value="Reset" />
    </form>
    <?php } ?>
</div>

# Slack Connector Module

## Overview

The Slack Connector Module integrates Drupal with Slack using legacy Incoming Webhooks. This integration lets you post messages from your Drupal site into Slack channels. **Note:** This module relies on Slack’s legacy Incoming Webhooks, which are deprecated in favor of Slack apps using OAuth and the Web API. More details can be found here: [Incoming Webhooks on Slack](https://makehaven.slack.com/marketplace/A0F7XDUAZ-incoming-webhooks).

## Setting Up in Slack

1. **Add an Incoming Webhook:**
   - Log in to your Slack workspace.
   - Visit the Incoming Webhooks page: [Slack Incoming Webhooks](https://makehaven.slack.com/marketplace/A0F7XDUAZ-incoming-webhooks)
   - Click **Add Configuration** to create a new incoming webhook.
   - Select the default channel where messages will be posted (this can be overridden in the payload if allowed).
   - Save your configuration to generate a unique Webhook URL.

2. **Copy the Webhook URL:**
   - Once saved, copy the generated Webhook URL. You will need this URL for the Drupal module configuration.

## Configuring the Module in Drupal

1. **Installation:**
   - Place the Slack Connector module in your custom modules directory.
   - Enable the module from the Drupal administration interface.

2. **Configuration:**
   - Navigate to **Administration > Configuration > Web Services > Slack Connector**.
   - Paste the copied Webhook URL into the **Slack Webhook URL** field.
   - Save the configuration.

3. **Testing:**
   - Use the provided **Test Slack Connection** button on the configuration page. This sends a test message (using a channel override, e.g. `#testing`) to verify the connection.
   - Check your Slack workspace to confirm that the message appears.

## Limitations and Future Considerations

- **Legacy Integration:**  
  This module uses legacy Incoming Webhooks. While they support a channel override via the JSON payload, the default channel is usually set at installation.
  
- **Dynamic Channel Posting:**  
  If you require dynamic channel posting or more advanced message formatting (using Block Kit), consider upgrading to a Slack app that uses OAuth and the `chat.postMessage` API.

- **Deprecation Notice:**  
  Legacy Incoming Webhooks are deprecated and may be removed in the future. Plan for a future upgrade if your integration needs expand.

## Additional Resources

- [Slack Incoming Webhooks Documentation](https://api.slack.com/incoming-webhooks)
- [Slack API Documentation](https://api.slack.com)

## Support

For issues or feature requests, please refer to the project’s issue queue or contact the maintainer.


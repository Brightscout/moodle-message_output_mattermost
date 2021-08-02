# Mattermost message processor
This plugin provides a message processor for Mattermost. A mattermost site can configure the [mattermost notification plugin](https://github.com/Brightscout/x-mattermost-plugin-moodle-notification) to be used for message outputs. Then, any Moodle users who are members of that mattermost site can configure their account to enable/disable mattermost notification and receive Moodle notifications to their mattermost account having the same email as the moodle account.

## Configuring the plugin settings

1. At the Mattermost plugin main settings page (Plugins / Message outputs / Mattermost), you will need to configure the Mattermost Server URL and Webhook secret for the Mattermost plugin. Once the plugin is installed, you will see:
    * ![image](https://user-images.githubusercontent.com/33994932/127824547-0d8f1ff8-d7fe-4b6c-b6a1-91693f782619.png)  

1. You can enter your Mattermost Server URL, but you will nedd to setup mattermost notification plugin to get the webhook secret. To do this, make sure you are logged into you mattermost server as an administrator. you can follow [these](https://github.com/Brightscout/x-mattermost-plugin-moodle-notification#installation) intructions to setup notification plugin.

1. After installing the plugin, you should go to the mattermost plugin's settings in System Console and regenerate the Webhook Secret:
    * ![image](https://user-images.githubusercontent.com/33994932/127828620-408e0a01-e266-4909-9dab-6d6c930bda0e.png)

1. Now you need to copy this secret to Moodle Mattermost plugin settings screen and save changes:
    * ![image](https://user-images.githubusercontent.com/33994932/127829320-79ae99fc-339f-42ac-95a7-15710fd7cffb.png)

## Configuring user preferences

Once Mattermost is configured for your site, users can enable/disable notifications from Moodle. This is done in the user preferences screen under the notification preferences. On that screen, you will see a column for Mattermost, and it will show the "alert" icon indicating that Mattermost notification is disabled. Click on that link to open the Mattermost settings dialogue:

   * ![image](https://user-images.githubusercontent.com/33994932/127831621-71101b07-6227-4cc4-9583-df19ed97b845.png)

Click the "Enable mattermost notification" button, and the user account with same email on mattermost and moodle will be connected. Now, the user can select what messages and notifications they wish to receive through Mattermost.


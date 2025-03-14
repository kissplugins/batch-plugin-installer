# KISS WP Batch Plugin Installer

A WordPress plugin that allows you to batch-install multiple plugins from GitHub ZIP URLs.

## Features (v1.0)

- **Batch Installation:** Select multiple plugins from the config file and install them in one go.
- **Configurable Sources:** Store plugin URLs in a `wpbatchinstaller-config.json` file located in the plugin folder.
- **Simple UI:** An admin page provides checkboxes for each plugin, plus a single button to install all selected plugins.
- **Success/Failure Notices:** Displays notices indicating whether each plugin was successfully installed or if an error occurred.

## Installation

1. Download this plugin and place it into your WordPress `plugins` directory (e.g., `/wp-content/plugins/kiss-wp-batch-plugin-installer`).
2. Inside that folder, create (or edit) the `wpbatchinstaller-config.json` file to specify your plugin ZIP URLs in valid JSON format:
   ```json
   {
     "KISS Maintenance Mode": "https://github.com/kissplugins/KISS-maintenance-mode/archive/refs/heads/main.zip",
     "KISS FAQs with Google Schema": "https://github.com/kissplugins/KISS-faqs/archive/refs/heads/main.zip",
     "KISS Last Post Update Timestamp": "https://github.com/kissplugins/kiss-post-last-update-date/archive/refs/heads/main.zip"
   }
   ```
3. Activate **KISS WP Batch Plugin Installer** in your WordPress Admin.
4. Go to **KISS WP Batch Plugin Installer** in the Admin Menu, uncheck any plugins you don’t wish to install, then click **Install selected plugins**.

## Usage

- Simply open the **KISS WP Batch Plugin Installer** menu page.
- Check or uncheck plugins you want to install.
- Click **Install selected plugins**.
- The plugin will download and install each checked plugin from its configured URL, displaying notices for success or error.

## License

This plugin is distributed under the **GPL v2** license.  
You can read more about GPL v2 here: [https://www.gnu.org/licenses/old-licenses/gpl-2.0.html](https://www.gnu.org/licenses/old-licenses/gpl-2.0.html)

### Disclaimer of Warranty

This plugin is distributed **as-is**, without any warranty.  
No author or distributor accepts responsibility to anyone for the consequences of using it or for whether it serves any particular purpose or works at all.  
This disclaimer of warranty extends to the user of this software and everyone else who comes into contact with it.  

Under the terms of the GPL v2, you may freely use, modify, and distribute this software, provided you preserve this license notice in the source code or documentation.


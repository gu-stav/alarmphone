# Alarmphone Wordpress Theme #
The Wordpress Theme for [alarmphone.org](http://alarmphone.org/).

## Pugins ##

### Required ###
- Advanced Custom Fields (Pro)

### Tested###
- Polylang for i18n Support

## Data Structure ##
On the start page 4 sections are displayed:
- **Intro**: To add a new Intro, please use "Intro" in the wordpress backend navigation. Always the latest published Post will be displayed.
- **Campaigns**: To add a new Campaign, please use "Campaign" in the wordpress backend navigation. The last 10 campaigns are displayed on the front-page. To view all campaigns on a single page, please use as link ``/campaigns/``.
- **Latest Posts**: All Posts in any category. The latest 10 published Posts are rendered.

### Posts ###
All Posts can have Material assigned. If the file is an image, and has no preview image, the image itself will be rendered as a preview. If the file is not an image, and not preview is set, the filetype will be rendered. The language is required to set the color in the Frontend.

### Pages ###
Pages are rendered like Posts.

#### Page-Templates ####
Pages can have 2 Templates:
- **Material**: The page itself will not render, but a list of the attached Material. Only the headline of the Page will be shown.
- **Safety at Sea**: This renders the Posts of the category "Safety at Sea" in a grid.

### Menus ###
Translation for Menus is supported through the Polylang Plugin.

- **Social Menu**: Rendered above the Header. Please use the name of the Network as Navigation-Text (e.g. "Facebook"), for using the Icon.
- **Main Menu**: Main Navigation Menu. Supported are 2 Levels.
- **Footer Menu**: Rendered below the content. Supported is one Level.

### Options ###
- Donation-URL: If set, a "Donate" Button will be rendered next to the Social Menu.

### Sidebar ###
- Widgets are supported. Styling was tested with the RSS-Widget.

## Translations ##
All used Strings in the Template can be translated in the Polylang-Backend. Right-to-Left language support should work. To use the translation interface please go to ``Settings -> Languages -> String Translation``.

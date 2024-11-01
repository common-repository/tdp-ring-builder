=== TDP Ring Builder ===
Contributors: thediamondport
Tags: ring builder, engagement ring, diamonds, lab diamond, natural diamond
Requires at least: 5.0
Tested up to: 6.6.2
Requires PHP: 7.0.0
Stable tag: 1.0.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

This plugin allows users to build custom diamond engagement rings, offering both lab and natural diamonds, as well as loose rings and loose diamonds.

== Description ==

The TDP Ring Builder Plugin is designed to enhance the shopping experience for users looking to create custom diamond engagement rings. It supports both lab-grown and natural diamonds, and allows customers to choose between loose rings, loose diamonds, or a complete engagement ring.

Key Features:
* Build custom engagement rings by selecting diamonds and ring settings.
* Supports lab-grown and natural diamonds.
* Allows the purchase of loose rings and loose diamonds.
* Seamless integration with WooCommerce.


== Additional Information ==

This plugin communicates with external APIs provided by [The Diamond Port](https://thediamondport.com/). Check their [Terms of Use](https://thediamondport.com/terms-and-conditions) and [Privacy Policy](https://thediamondport.com/privacy-policy). 

**Note:** Users may need to create an account with The Diamond Port to use certain features of this plugin.

== Installation ==
To install the TDP Ring Builder Plugin:

1. Upload `tdp-rb` to the `/wp-content/plugins/` directory.
2. Activate the plugin through the \'Plugins\' menu in WordPress.
3. Use the provided shortcode `[Ring_Builder]` to display the ring builder on any page.


### Source Code 
The original unminified source code for JavaScript and CSS files is available within the plugin in the `/vue-vite-app/src` directory.

For developers who wish to view or modify the source, please refer to the `/vue-vite-app/src` folder.

### External References

This plugin uses Vue.js and Vuex for frontend functionality. Some metadata and URLs referencing these libraries may be included in the generated build files. These URLs are part of the open-source licenses of these libraries and do not affect the performance of the plugin.

For more information about these libraries:
- Vue.js: https://vuejs.org/
- Vuex: https://next.vuex.vuejs.org/

### Vue Vite App

This project is a Vue.js application built with Vite, designed to be a WordPress plugin. It utilizes various dependencies for routing, state management, styling, and other features. 

### Table of Contents

- [Requirements](#requirements)
- [Installation](#installation)
- [Development](#development)
- [Building the Project](#building-the-project)
- [Usage](#usage)
  - [Dependencies](#dependencies)
    - [Vue](#vue)
    - [Vue Router](#vue-router)
    - [Vuex](#vuex)
    - [Axios](#axios)
    - [Tailwind CSS](#tailwind-css)
    - [Vue Slider Component](#vue-slider-component)
- [Contributing](#contributing)
- [License](#license)

### Requirements

- Node.js (v14 or higher)
- npm (v6 or higher)

### Installation

Install the dependencies:
   ```bash
   npm install
   ```

### Development

To start the development server, run:
```bash
npm run dev
```

This will start the Vite development server, and you can view the application in your browser at `http://localhost:3000`.

### Building the Project

To build the project for production, run:
```bash
npm run build
```

This command will generate the production files in the `dist` directory, which you can upload to your WordPress plugin folder.

### For Developers Only:-

### Dependencies

#### Vue
- **Version**: ^3.4.34
- **Description**: Vue.js is a progressive JavaScript framework for building user interfaces.
- **Usage**: Import Vue components in your application by using:
  ```javascript
  import { createApp } from 'vue';
  import App from './App.vue';

  createApp(App).mount('#app');
  ```

#### Vue Router
- **Version**: ^4.4.0
- **Description**: Vue Router is the official router for Vue.js, allowing you to create single-page applications with navigation.
- **Usage**: Define routes in your application:
  ```javascript
  import { createRouter, createWebHistory } from 'vue-router';
  import Home from './pages/Home.vue';
  
  const routes = [
    { path: '/', component: Home },
  ];
  
  const router = createRouter({
    history: createWebHistory(),
    routes,
  });
  
  export default router;
  ```

#### Vuex
- **Version**: ^4.0.2
- **Description**: Vuex is a state management pattern + library for Vue.js applications.
- **Usage**: Create a store to manage your application state:
  ```javascript
  import { createStore } from 'vuex';

  const store = createStore({
    state() {
      return {
        count: 0
      };
    },
    mutations: {
      increment(state) {
        state.count++;
      }
    }
  });

  export default store;
  ```

#### Axios
- **Version**: ^1.7.3
- **Description**: Axios is a promise-based HTTP client for the browser and Node.js.
- **Usage**: Make HTTP requests:
  ```javascript
  import axios from 'axios';

  axios.get('/api/data')
    .then(response => {
      console.log(response.data);
    });
  ```

#### Tailwind CSS
- **Version**: ^3.4.7
- **Description**: Tailwind CSS is a utility-first CSS framework for creating custom designs.
- **Usage**: Use the utility classes in your HTML/JSX:
  ```html
  <div class="tdprb-bg-backgroundColor tdprb-text-textPrimaryColor">Hello, World!</div>
  ```

#### Vue Slider Component
- **Version**: ^4.1.0-beta.7
- **Description**: A Vue slider component for selecting values.
- **Usage**: Use it in your components:
  ```html
  <vue-slider v-model="value"></vue-slider>
  ```

== Frequently Asked Questions ==

= How do I add the ring builder to my site? =

Simply use the shortcode `[Ring_Builder]` on any page where you want to display the ring builder.

= Can I customize the appearance of the ring builder? =

Yes, you can customize the appearance through the backend settings provided by the plugin. These settings include:

* **Lab Grown Settings:** Customize options related to lab-grown diamonds.
* **Natural Settings:** Adjust settings for natural diamonds.
* **Ring Settings:** Modify the appearance and options for ring settings.
* Additionally, the plugin offers an order list to view customer orders.

== Screenshots ==
1. Example of the ring builder interface where users select diamonds and ring settings.
2. Screenshot showing the loose diamond and loose ring selection options.

== Changelog ==
= 1.0 =
* Initial release of the TDP Ring Builder Plugin.

== Upgrade Notice ==
= 1.0 =
Initial release. No upgrade notices are necessary.
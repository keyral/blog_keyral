<?php

/**
 * @file
 * Documentation landing page and topics, plus core library hooks.
 */

/**
 * @mainpage
 * Welcome to the Drupal API Documentation!
 *
 * This site is an API reference for Drupal, generated from comments embedded
 * in the source code. More in-depth documentation can be found at
 * https://drupal.org/developing/api.
 *
 * Here are some topics to help you get started developing with Drupal.
 *
 * @section essentials Essential background concepts
 *
 * - @link oo_conventions Object-oriented conventions used in Drupal @endlink
 * - @link extending Extending and altering Drupal @endlink
 * - @link best_practices Security and best practices @endlink
 * - @link info_types Types of information in Drupal @endlink
 *
 * @section interface User interface
 *
 * - @link menu Routing, page controllers, and menu entries @endlink
 * - @link form_api Forms @endlink
 * - @link block_api Blocks @endlink
 * - @link ajax Ajax @endlink
 *
 * @section store_retrieve Storing and retrieving data
 *
 * - @link entity_api Entities @endlink
 * - @link field Fields @endlink
 * - @link config_api Configuration API @endlink
 * - @link state_api State API @endlink
 * - @link views_overview Views @endlink
 * - @link database Database abstraction layer @endlink
 *
 * @section other_essentials Other essential APIs
 *
 * - @link plugin_api Plugins @endlink
 * - @link container Services and the Dependency Injection Container @endlink
 * - @link i18n Internationalization @endlink
 * - @link cache Caching @endlink
 * - @link utility Utility classes and functions @endlink
 * - @link user_api User accounts, permissions, and roles @endlink
 * - @link theme_render Theme system and render API @endlink
 * - @link migration Migration @endlink
 *
 * @section additional Additional topics
 *
 * - @link batch Batch API @endlink
 * - @link queue Queue API @endlink
 * - @link typed_data Typed Data @endlink
 * - @link testing Automated tests @endlink
 * - @link third_party Integrating third-party applications @endlink
 *
 * @section more_info Further information
 *
 * - @link https://api.drupal.org/api/drupal/groups/8 All topics @endlink
 * - @link https://drupal.org/project/examples Examples project (sample modules) @endlink
 * - @link https://drupal.org/list-changes API change notices @endlink
 * - @link https://drupal.org/developing/api/8 Drupal 8 API longer references @endlink
 */

/**
 * @defgroup third_party REST and Application Integration
 * @{
 * Integrating third-party applications using REST and related operations.
 *
 * @section sec_overview Overview of web services
 * Web services make it possible for applications and web sites to read and
 * update information from other web sites. There are several standard
 * techniques for providing web services, including:
 * - SOAP: http://en.wikipedia.org/wiki/SOAP SOAP
 * - XML-RPC: http://en.wikipedia.org/wiki/XML-RPC
 * - REST: http://en.wikipedia.org/wiki/Representational_state_transfer
 * Drupal sites can both provide web services and integrate third-party web
 * services.
 *
 * @section sec_rest_overview Overview of REST
 * The REST technique uses basic HTTP requests to obtain and update data, where
 * each web service defines a specific API (HTTP GET and/or POST parameters and
 * returned response) for its HTTP requests. REST requests are separated into
 * several types, known as methods, including:
 * - GET: Requests to obtain data.
 * - PUT: Requests to update or create data.
 * - PATCH: Requests to update a subset of data, such as one field.
 * - DELETE: Requests to delete data.
 * The Drupal Core REST module provides support for GET, PUT, PATCH, and DELETE
 * quests on entities, GET requests on the database log from the Database
 * Logging module, and a plugin framework for providing REST support for other
 * data and other methods.
 *
 * REST requests can be authenticated. The Drupal Core Basic Auth module
 * provides authentication using the HTTP Basic protocol; contributed module
 * OAuth (https://www.drupal.org/project/oauth) implements the OAuth
 * authenticaion protocol. You can also use cookie-based authentication, which
 * would require users to be logged into the Drupal site while using the
 * application on the third-party site that is using the REST service.
 *
 * @section sec_rest Enabling REST for entities and the log
 * Here are the steps to take to use the REST operations provided by Drupal
 * Core:
 * - Enable the REST module, plus Basic Auth (or another authentication method)
 *   and HAL.
 * - Node entity support is configured by default. If you would like to support
 *   other types of entities, you can copy
 *   core/modules/rest/config/install/rest.settings.yml to your staging
 *   configuration directory, appropriately modified for other entity types,
 *   and import it. Support for GET on the log from the Database Logging module
 *   can also be enabled in this way; in this case, the 'entity:node' line
 *   in the configuration would be replaced by the appropriate plugin ID,
 *   'dblog'.
 * - Set up permissions to allow the desired REST operations for a role, and set
 *   up one or more user accounts to perform the operations.
 * - To perform a REST operation, send a request to either the canonical URL
 *   for an entity (such as node/12345 for a node), or if the entity does not
 *   have a canonical URL, a URL like entity/(type)/(ID). The URL for a log
 *   entry is dblog/(ID). The request must have the following properties:
 *   - The request method must be set to the REST method you are using (POST,
 *     GET, PATCH, etc.).
 *   - The content type for the data you send, or the accept type for the
 *     data you are receiving, must be set to 'application/hal+json'.
 *   - If you are sending data, it must be JSON-encoded.
 *   - You'll also need to make sure the authentication information is sent
 *     with the request, unless you have allowed access to anonymous users.
 *
 * For more detailed information on setting up REST, see
 * https://www.drupal.org/documentation/modules/rest.
 *
 * @section sec_plugins Defining new REST plugins
 * The REST framework in the REST module has support built in for entities, but
 * it is also an extensible plugin-based system. REST plugins implement
 * interface \Drupal\rest\Plugin\ResourceInterface, and generally extend base
 * class \Drupal\rest\Plugin\ResourceBase. They are annotated with
 * \Drupal\rest\Annotation\RestResource annotation, and must be in plugin
 * namespace subdirectory Plugin\rest\resource. For more information on how to
 * create plugins, see the @link plugin_api Plugin API topic. @endlink
 *
 * If you create a new REST plugin, you will also need to enable it by
 * providing default configuration or configuration import, as outlined in
 * @ref sec_rest above.
 *
 * @section sec_xmlrpc Using XML-RPC
 * In XML-RPC, a web site can set up one or more XML-RPC methods, which it
 * will usually service at a central XML-RPC URL. Drupal Core's XML-RPC module
 * provides both client and server XML-RPC functionality.
 *
 * On the server side, the XML-RPC module sets up URL path xmlrpc.php, which
 * responds to XML-RPC requests. Individual XML-RPC request methods are defined
 * by modules by implementing hook_xmlrpc(); Drupal Core does not define any
 * XML-RPC web service requests by default.
 *
 * On the client side, XML-RPC requests to other web sites that provide XML-RPC
 * web services can be performed in Drupal by using the xmlrpc() function.
 *
 * @section sec_integrate Integrating data from other sites into Drupal
 * If you want to integrate data from other web sites into Drupal, here are
 * some notes:
 * - There are contributed modules available for integrating many third-party
 *   sites into Drupal. Search on https://www.drupal.org/project/project_module
 * - If there is not an existing module, you will need to find documentation on
 *   the specific web services API for the site you are trying to integrate.
 * - There are several classes and functions that are useful for interacting
 *   with web services:
 *   - You should make requests using the 'http_client' service, which
 *     implements \GuzzleHttp\ClientInterface. See the
 *     @link container Services topic @endlink for more information on
 *     services. If you cannot use dependency injection to retrieve this
 *     service, the \Drupal::httpClient() method is available. A good example
 *     of how to use this service can be found in
 *     \Drupal\aggregator\Plugin\aggregator\fetcher\DefaultFetcher
 *   - \Drupal\Component\Serialization\Json (JSON encoding and decoding).
 *   - PHP has functions and classes for parsing XML; see
 *     http://php.net/manual/refs.xml.php
 *   - As mentioned above, for XML-RPC requests, use function xmlrpc().
 * @}
 */

/**
 * @defgroup state_api State API
 * @{
 * Information about the State API.
 *
 * The State API is one of several methods in Drupal for storing information.
 * See the @link info_types Information types topic @endlink for an
 * overview of the different types of information.
 *
 * The basic entry point into the State API is \Drupal::state(), which returns
 * an object of class \Drupal\Core\State\StateInterface. This class has
 * methods for storing and retrieving state information; each piece of state
 * information is associated with a string-valued key. Example:
 * @code
 * // Get the state class.
 * $state = \Drupal::state();
 * // Find out when cron was last run; the key is 'system.cron_last'.
 * $time = $state->get('system.cron_last');
 * // Set the cron run time to the current request time.
 * $state->set('system_cron_last', REQUEST_TIME);
 * @endcode
 *
 * For more on the State API, see https://drupal.org/developing/api/8/state
 * @}
 */

/**
 * @defgroup config_api Configuration API
 * @{
 * Information about the Configuration API.
 *
 * The Configuration API is one of several methods in Drupal for storing
 * information. See the @link info_types Information types topic @endlink for
 * an overview of the different types of information. The sections below have
 * more information about the configuration API; see
 * https://drupal.org/developing/api/8/configuration for more details.
 *
 * @section sec_storage Configuration storage
 * In Drupal, there is a concept of the "active" configuration, which is the
 * configuration that is currently in use for a site. The storage used for the
 * active configuration is configurable: it could be in the database, in files
 * in a particular directory, or in other storage backends; the default storage
 * is in the database. Module developers must use the configuration API to
 * access the active configuration, rather than being concerned about the
 * details of where and how it is stored.
 *
 * Configuration is divided into individual objects, each of which has a
 * unique name or key. Some modules will have only one configuration object,
 * typically called 'mymodule.settings'; some modules will have many. Within
 * a configuration object, configuration settings have data types (integer,
 * string, Boolean, etc.) and settings can also exist in a nested hierarchy,
 * known as a "mapping".
 *
 * Configuration can also be overridden on a global, per-language, or
 * per-module basis. See https://www.drupal.org/node/1928898 for more
 * information.
 *
 * @section sec_yaml Configuration YAML files
 * Whether or not configuration files are being used for the active
 * configuration storage on a particular site, configuration files are always
 * used for:
 * - Defining the default configuration for a module, which is imported to the
 *   active storage when the module is enabled. Note that changes to this
 *   default configuration after a module is already enabled have no effect;
 *   to make a configuration change after a module is enabled, you would need
 *   to uninstall/reinstall or use a hook_update_N() function.
 * - Exporting and importing configuration.
 *
 * The file storage format for configuration information in Drupal is @link
 * http://en.wikipedia.org/wiki/YAML YAML files. @endlink Configuration is
 * divided into files, each containing one configuration object. The file name
 * for a configuration object is equal to the unique name of the configuration,
 * with a '.yml' extension. The default configuration files for each module are
 * placed in the config/install directory under the top-level module directory,
 * so look there in most Core modules for examples.
 *
 * Each configuration file has a specific structure, which is expressed as a
 * YAML-based configuration schema. The configuration schema details the
 * structure of the configuration, its data types, and which of its values need
 * to be translatable. Each module needs to define its configuration schema in
 * files in the config/schema directory under the top-level module directory, so
 * look there in most Core modules for examples. Note that data types label,
 * text, and data_format are translatable; string is non-translatable text.
 *
 * @section sec_simple Simple configuration
 * The simple configuration API should be used for information that will always
 * have exactly one copy or version. For instance, if your module has a
 * setting that is either on or off, then this is only defined once, and it
 * would be a Boolean-valued simple configuration setting.
 *
 * The first task in using the simple configuration API is to define the
 * configuration file structure, file name, and schema of your settings (see
 * @ref sec_yaml above). Once you have done that, you can retrieve the
 * active configuration object that corresponds to configuration file
 * mymodule.foo.yml with a call to:
 * @code
 * $config = \Drupal::config('mymodule.foo');
 * @endcode
 *
 * This will be an object of class \Drupal\Core\Config\Config, which has methods
 * for getting and setting configuration information.  For instance, if your
 * YAML file structure looks like this:
 * @code
 * enabled: '0'
 * bar:
 *   baz: 'string1'
 *   boo: 34
 * @endcode
 * you can make calls such as:
 * @code
 * // Get a single value.
 * $enabled = $config->get('enabled');
 * // Get an associative array.
 * $bar = $config->get('bar');
 * // Get one element of the array.
 * $bar_baz = $config->get('bar.baz');
 * // Update a value. Nesting works the same as get().
 * $config->set('bar.baz', 'string2');
 * // Nothing actually happens with set() until you call save().
 * $config->save();
 * @endcode
 *
 * @section sec_entity Configuration entities
 * In contrast to the simple configuration settings described in the previous
 * section, if your module allows users to create zero or more items (where
 * "items" are things like content type definitions, view definitions, and the
 * like), then you need to define a configuration entity type to store your
 * configuration. Creating an entity type, loading entites, and querying them
 * are outlined in the @link entity_api Entity API topic. @endlink Here are a
 * few additional steps and notes specific to configuration entities:
 * - For examples, look for classes that implement
 *   \Drupal\Core\Config\Entity\ConfigEntityInterface -- one good example is
 *   the \Drupal\user\Entity\Role entity type.
 * - In the entity type annotation, you will need to define a 'config_prefix'
 *   string. When Drupal stores a configuration item, it will be given a name
 *   composed of your module name, your chosen config prefix, and the ID of
 *   the individual item, separated by '.'. For example, in the Role entity,
 *   the config prefix is 'role', so one configuration item might be named
 *   user.role.anonymous, with configuration file user.role.anonymous.yml.
 * - You will need to define the schema for your configuration in your
 *   modulename.schema.yml file, with an entry for 'modulename.config_prefix.*'.
 *   For example, for the Role entity, the file user.schema.yml has an entry
 *   user.role.*; see @ref sec_yaml above for more information.
 * - Your module may also provide a few configuration items to be installed by
 *   default, by adding configuration files to the module's config/install
 *   directory; see @ref sec_yaml above for more information.
 * - Some configuration entities have dependencies on other configuration
 *   entities, and module developers need to consider this so that configuration
 *   can be imported, uninstalled, and synchronized in the right order. For
 *   example, a field display configuration entity would need to depend on
 *   field instance configuration, which depends on field and bundle
 *   configuration. Configuration entity classes expose dependencies by
 *   overriding the
 *   \Drupal\Core\Config\Entity\ConfigEntityInterface::calculateDependencies()
 *   method.
 *
 * @see i18n
 *
 * @}
 */

/**
 * @defgroup cache Cache API
 * @{
 * Information about the Drupal Cache API
 *
 * @section basics Basics
 *
 * Note: If not specified, all of the methods mentioned here belong to
 * \Drupal\Core\Cache\CacheBackendInterface.
 *
 * The Cache API is used to store data that takes a long time to
 * compute. Caching can be permanent, temporary, or valid for a certain
 * timespan, and the cache can contain any type of data.
 *
 * To use the Cache API:
 * - Request a cache object through \Drupal::cache() or by injecting a cache
 *   service.
 * - Define a Cache ID (cid) value for your data. A cid is a string, which must
 *   contain enough information to uniquely identify the data. For example, if
 *   your data contains translated strings, then your cid value must include the
 *   current interface language.
 * - Call the get() method to attempt a cache read, to see if the cache already
 *   contains your data.
 * - If your data is not already in the cache, compute it and add it to the
 *   cache using the set() method. The third argument of set() can be used to
 *   control the lifetime of your cache item.
 *
 * Example:
 * @code
 * $cid = 'mymodule_example:' . \Drupal::languageManager()->getCurrentLanguage()->id();
 *
 * $data = NULL;
 * if ($cache = \Drupal::cache()->get($cid)) {
 *   $data = $cache->data;
 * }
 * else {
 *   $data = my_module_complicated_calculation();
 *   \Drupal::cache()->set($cid, $data);
 * }
 * @endcode
 *
 * Note the use of $data and $cache->data in the above example. Calls to
 * \Drupal::cache()->get() return a record that contains the information stored
 * by \Drupal::cache()->set() in the data property as well as additional meta
 * information about the cached data. In order to make use of the cached data
 * you can access it via $cache->data.
 *
 * @section bins Cache bins
 *
 * Cache storage is separated into "bins", each containing various cache items.
 * Each bin can be configured separately; see @ref configuration.
 *
 * When you request a cache object, you can specify the bin name in your call to
 * \Drupal::cache(). Alternatively, you can request a bin by getting service
 * "cache.nameofbin" from the container. The default bin is called "default", with
 * service name "cache.default", it is used to store common and frequently used
 * caches.
 *
 * Other common cache bins are the following:
 *   - bootstrap: Small caches needed for the bootstrap on every request.
 *   - render: Contains cached HTML strings like cached pages and blocks, can
 *     grow to large size.
 *   - data: Contains data that can vary by path or similar context.
 *   - discovery: Contains cached discovery data for things such as plugins,
 *     views_data, or YAML discovered data such as library info.
 *
 * A module can define a cache bin by defining a service in its
 * modulename.services.yml file as follows (substituting the desired name for
 * "nameofbin"):
 * @code
 * cache.nameofbin:
 *   class: Drupal\Core\Cache\CacheBackendInterface
 *   tags:
 *     - { name: cache.bin }
 *   factory_method: get
 *   factory_service: cache_factory
 *   arguments: [nameofbin]
 * @endcode
 *
 * @section delete Deletion
 *
 * There are two ways to remove an item from the cache:
 * - Deletion (using delete(), deleteMultiple() or deleteAll()) permanently
 *   removes the item from the cache.
 * - Invalidation (using invalidate(), invalidateMultiple() or invalidateAll())
 *   is a "soft" delete that only marks items as "invalid", meaning "not fresh"
 *   or "not fresh enough". Invalid items are not usually returned from the
 *   cache, so in most ways they behave as if they have been deleted. However,
 *   it is possible to retrieve invalid items, if they have not yet been
 *   permanently removed by the garbage collector, by passing TRUE as the second
 *   argument for get($cid, $allow_invalid).
 *
 * Use deletion if a cache item is no longer useful; for instance, if the item
 * contains references to data that has been deleted. Use invalidation if the
 * cached item may still be useful to some callers until it has been updated
 * with fresh data. The fact that it was fresh a short while ago may often be
 * sufficient.
 *
 * Invalidation is particularly useful to protect against stampedes. Rather than
 * having multiple concurrent requests updating the same cache item when it
 * expires or is deleted, there can be one request updating the cache, while the
 * other requests can proceed using the stale value. As soon as the cache item
 * has been updated, all future requests will use the updated value.
 *
 * @section tags Cache Tags
 *
 * The fourth argument of the set() method can be used to specify cache tags,
 * which are used to identify what type of data is included in each cache item.
 * Each cache item can have multiple cache tags, and each cache tag has a string
 * key and a value. The value can be:
 * - TRUE, to indicate that this type of data is present in the cache item.
 * - An array of values. For example, the "node" tag indicates that particular
 *   node's data is present in the cache item, so its value is an array of node
 *   IDs.
 * Data that has been tagged can be deleted or invalidated as a group: no matter
 * the Cache ID (cid) of the cache item, no matter in which cache bin a cache
 * item lives; as long as it is tagged with a certain cache tag, it will be
 * deleted or invalidated.
 *
 * Because of that, cache tags are a solution to the cache invalidation problem:
 * - For caching to be effective, each cache item must only be invalidated when
 *   absolutely necessary. (i.e. maximizing the cache hit ratio.)
 * - For caching to be correct, each cache item that depends on a certain thing
 *   must be invalidated whenever that certain thing is modified.
 *
 * A typical scenario: a user has modified a node that appears in two views,
 * three blocks and on twelve pages. Without cache tags, we couldn't possibly
 * know which cache items to invalidate, so we'd have to invalidate everything:
 * we had to sacrifice effectiveness to achieve correctness. With cache tags, we
 * can have both.
 *
 * Example:
 * @code
 * // A cache item with nodes, users, and some custom module data.
 * $tags = array(
 *   'my_custom_tag' => TRUE,
 *   'node' => array(1, 3),
 *   'user' => array(7),
 * );
 * \Drupal::cache()->set($cid, $data, CacheBackendInterface::CACHE_PERMANENT, $tags);
 *
 * // Delete or invalidate all cache items with certain tags.
 * \Drupal\Core\Cache\Cache::deleteTags(array('node' => array(1));
 * \Drupal\Core\Cache\Cache::invalidateTags(array('user' => array(1)));
 * @endcode
 *
 * Drupal is a content management system, so naturally you want changes to your
 * content to be reflected everywhere, immediately. That's why we made sure that
 * every entity type in Drupal 8 automatically has support for cache tags: when
 * you save an entity, you can be sure that the cache items that have the
 * corresponding cache tags will be invalidated.
 * This also is the case when you define your own entity types: you'll get the
 * exact same cache tag invalidation as any of the built-in entity types, with
 * the ability to override any of the default behavior if needed.
 * See \Drupal\Core\Entity\EntityInterface::getCacheTag(),
 * \Drupal\Core\Entity\EntityInterface::getListCacheTags(),
 * \Drupal\Core\Entity\Entity::invalidateTagsOnSave() and
 * \Drupal\Core\Entity\Entity::invalidateTagsOnDelete().
 *
 * @todo Update cache tag deletion in https://drupal.org/node/918538
 *
 * @section configuration Configuration
 *
 * By default cached data is stored in the database. This can be configured
 * though so that all cached data, or that of an individual cache bin, uses a
 * different cache backend, such as APC or Memcache, for storage.
 *
 * In a settings.php file, you can override the service used for a particular
 * cache bin. For example, if your service implementation of
 * \Drupal\Core\Cache\CacheBackendInterface was called cache.custom, the
 * following line would make Drupal use it for the 'cache_render' bin:
 * @code
 *  $settings['cache']['bins']['render'] = 'cache.custom';
 * @endcode
 *
 * Additionally, you can register your cache implementation to be used by
 * default for all cache bins with:
 * @code
 *  $settings['cache']['default'] = 'cache.custom';
 * @endcode
 *
 * @see https://drupal.org/node/1884796
 * @}
 */

/**
 * @defgroup user_api User accounts, permissions, and roles
 * @{
 * API for user accounts, access checking, roles, and permissions.
 *
 * @sec sec_overview Overview and terminology
 * Drupal's permission system is based on the concepts of accounts, roles,
 * and permissions.
 *
 * Users (site visitors) have accounts, which include a user name, an email
 * address, a password (or some other means of authentication), and possibly
 * other fields (if defined on the site). Anonymous users have an implicit
 * account that does not have a real user name or any account information.
 *
 * Each user account is assigned one or more roles. The anonymous user account
 * automatically has the anonymous user role; real user accounts
 * automatically have the authenticated user role, plus any roles defined on
 * the site that they have been assigned.
 *
 * Each role, including the special anonymous and authenticated user roles, is
 * granted one or more named permissions, which allow them to perform certain
 * tasks or view certain content on the site. It is possible to designate a
 * role to be the "administrator" role; if this is set up, this role is
 * automatically granted all available permissions whenever a module is
 * enabled that defines permissions.
 *
 * All code in Drupal that allows users to perform tasks or view content must
 * check that the current user has the correct permission before allowing the
 * action. In the standard case, access checking consists of answering the
 * question "Does the current user have permission 'foo'?", and allowing or
 * denying access based on the answer. Note that access checking should nearly
 * always be done at the permission level, not by checking for a particular role
 * or user ID, so that site administrators can set up user accounts and roles
 * appropriately for their particular sites.
 *
 * @sec sec_define Defining permissions
 * Modules define permissions by implementing hook_permission(). The return
 * value defines machine names, human-readable names, and optionally
 * descriptions for each permission type. The machine names are the canonical
 * way to refer to permissions for access checking.
 *
 * @sec sec_access Access permission checking
 * Depending on the situation, there are several methods for ensuring that
 * access checks are done properly in Drupal:
 * - Routes: When you register a route, include a 'requirements' section that
 *   either gives the machine name of the permission that is needed to visit the
 *   URL of the route, or tells Drupal to use an access check method or service
 *   to check access. See the @link menu Routing topic @endlink for more
 *   information.
 * - Entities: Access for various entity operations is designated either with
 *   simple permissions or access controller classes in the entity annotation.
 *   See the @link entity_api Entity API topic @endlink for more information.
 * - Other code: There is a 'current_user' service, which can be injected into
 *   classes to provide access to the current user account (see the
 *   @link container Services and Dependency Injection topic @endlink for more
 *   information on dependency injection). In code that cannot use dependency
 *   injection, you can access this service and retrieve the current user
 *   account object by calling \Drupal::currentUser(). Once you have a user
 *   object for the current user (implementing \Drupal\user\UserInterface), you
 *   can call inherited method
 *   \Drupal\Core\Session\AccountInterface::hasPermission() to check
 *   permissions, or pass this object into other functions/methods.
 * - Forms: Each element of a form array can have a Boolean '#access' property,
 *   which determines whether that element is visible and/or usable. This is a
 *   common need in forms, so the current user service (described above) is
 *   injected into the form base class as method
 *   \Drupal\Core\Form\FormBase::currentUser().
 *
 * @sec sec_entities User and role objects
 * User objects in Drupal are entity items, implementing
 * \Drupal\user\UserInterface. Role objects in Drupal are also entity items,
 * implementing \Drupal\user\RoleInterface. See the
 * @link entity_api Entity API topic @endlink for more information about
 * entities in general (including how to load, create, modify, and query them).
 *
 * Roles often need to be manipulated in automated test code, such as to add
 * permissions to them. Here's an example:
 * @code
 * $role = \Drupal\user\Entity\Role::load('authenticated');
 * $role->grantPermission('access comments');
 * $role->save();
 * @endcode
 *
 * Other important interfaces:
 * - \Drupal\Core\Session\AccountInterface: The part of UserInterface that
 *   deals with access checking. In writing code that checks access, your
 *   method parameters should use this interface, not UserInterface.
 * - \Drupal\Core\Session\AccountProxyInterface: The interface for the
 *   current_user service (described above).
 * @}
 */

/**
 * @defgroup container Services and Dependency Injection Container
 * @{
 * Overview of the Dependency Injection Container and Services.
 *
 * @todo write this
 *
 * Additional documentation paragraphs need to be written, and functions,
 * classes, and interfaces need to be added to this topic.
 *
 * See https://drupal.org/node/2133171
 * @}
 */

/**
 * @defgroup typed_data Typed Data API
 * @{
 * API for describing data based on a set of available data types.
 *
 * The Typed Data API was created to provide developers with a consistent
 * interface for interacting with data, as well as an API for metadata
 * (information about the data, such as the data type, whether it is
 * translatable, and who can access it). The Typed Data API is used in several
 * Drupal sub-systems, such as the Entity Field API and Configuration API.
 *
 * See https://drupal.org/node/1794140 for more information about the Typed
 * Data API.
 *
 * @section interfaces Interfaces and classes in the Typed Data API
 * There are several basic interfaces in the Typed Data API, representing
 * different types of data:
 * - \Drupal\Core\TypedData\PrimitiveInterface: Used for primitive data, such
 *   as strings, numeric types, etc. Drupal provides primitive types for
 *   integers, strings, etc. based on this interface, and you should
 *   not ever need to create new primitive types.
 * - \Drupal\Core\TypedData\TypedDataInterface: Used for single pieces of data,
 *   with some information about its context. Abstract base class
 *   \Drupal\Core\TypedData\TypedData is a useful starting point, and contains
 *   documentation on how to extend it.
 * - \Drupal\Core\TypedData\ComplexDataInterface: Used for complex data, which
 *   contains named and typed properties; extends TypedDataInterface. Examples
 *   of complex data include content entities and field items. See the
 *   @link entity_api Entity API topic @endlink for more information about
 *   entities; for most complex data, developers should use entities.
 * - \Drupal\Core\TypedData\ListInterface: Used for a sequential list of other
 *   typed data. Class \Drupal\Core\TypedData\Plugin\DataType\ItemList is a
 *   generic implementation of this interface, and it is used by default for
 *   data declared as a list of some other data type. You can also define a
 *   custom list class, in which case ItemList is a useful base class.
 *
 * @section defining Defining data types
 * To define a new data type:
 * - Create a class that implements one of the Typed Data interfaces.
 *   Typically, you will want to extend one of the classes listed in the
 *   section above as a starting point.
 * - Make your class into a DataType plugin. To do that, put it in namespace
 *   \Drupal\yourmodule\Plugin\DataType (where "yourmodule" is your module's
 *   short name), and add annotation of type
 *   \Drupal\Core\TypedData\Annotation\DataType to the documentation header.
 *   See the @link plugin_api Plugin API topic @endlink and the
 *   @link annotation Annotations topic @endlink for more information.
 *
 * @section using Using data types
 * The data types of the Typed Data API can be used in several ways, once they
 * have been defined:
 * - In the Field API, data types can be used as the class in the property
 *   definition of the field. See the @link field Field API topic @endlink for
 *   more information.
 * - In configuration schema files, you can use the unique ID ('id' annotation)
 *   from any DataType plugin class as the 'type' value for an entry. See the
 *   @link config_api Confuration API topic @endlink for more information.
 * @}
 */

/**
 * @defgroup migration Migration API
 * @{
 * Overview of the Migration API, which migrates data into Drupal.
 *
 * @todo write this
 *
 * Additional documentation paragraphs need to be written, and functions,
 * classes, and interfaces need to be added to this topic.
 *
 * See https://drupal.org/node/2127611
 * @}
 */

/**
 * @defgroup testing Automated tests
 * @{
 * Overview of PHPUnit tests and Simpletest tests.
 *
 * The Drupal project has embraced a philosophy of using automated tests,
 * consisting of both unit tests (which test the functionality of classes at a
 * low level) and functional tests (which test the functionality of Drupal
 * systems at a higher level, usually involving web output). The goal is to
 * have test coverage for all or most of the components and features, and to
 * run the automated tests before any code is changed or added, to make sure
 * it doesn't break any existing functionality (regression testing).
 *
 * In order to implement this philosophy, developers need to do the following:
 * - When making a patch to fix a bug, make sure that the bug fix patch includes
 *   a test that fails without the code change and passes with the code change.
 *   This helps reviewers understand what the bug is, demonstrates that the code
 *   actually fixes the bug, and ensures the bug will not reappear due to later
 *   code changes.
 * - When making a patch to implement a new feature, include new unit and/or
 *   functional tests in the patch. This serves to both demonstrate that the
 *   code actually works, and ensure that later changes do not break the new
 *   functionality.
 *
 * @section write_unit Writing PHPUnit tests for classes
 * PHPUnit tests for classes are written using the industry-standard PHPUnit
 * framework. Use a PHPUnit test to test functionality of a class if the Drupal
 * environment (database, settings, etc.) and web browser are not needed for the
 * test, or if the Drupal environment can be replaced by a "mock" object. To
 * write a PHPUnit test:
 * - Define a class that extends \Drupal\Tests\UnitTestCase.
 * - The class name needs to end in the word Test.
 * - The namespace must be a subspace/subdirectory of \Drupal\yourmodule\Tests,
 *   where yourmodule is your module's machine name.
 * - The test class file must be named and placed under the yourmodule/tests/src
 *   directory, according to the PSR-4 standard.
 * - Your test class needs a getInfo() method, which gives information about
 *   the test.
 * - Methods in your test class whose names start with 'test' are the actual
 *   test cases. Each one should test a logical subset of the functionality.
 * For more details, see:
 * - https://drupal.org/phpunit for full documentation on how to write PHPUnit
 *   tests for Drupal.
 * - http://phpunit.de for general information on the PHPUnit framework.
 * - @link oo_conventions Object-oriented programming topic @endlink for more
 *   on PSR-4, namespaces, and where to place classes.
 *
 * @section write_functional Writing functional tests
 * Functional tests are written using a Drupal-specific framework that is, for
 * historical reasons, known as "Simpletest". Use a Simpletest test to test the
 * functionality of sub-system of Drupal, if the functionality depends on the
 * Drupal database and settings, or to test the web output of Drupal. To
 * write a Simpletest test:
 * - For functional tests of the web output of Drupal, define a class that
 *   extends \Drupal\simpletest\WebTestBase, which contains an internal web
 *   browser and defines many helpful test assertion methods that you can use
 *   in your tests. You can specify modules to be enabled by defining a
 *   $modules member variable -- keep in mind that by default, WebTestBase uses
 *   a "testing" install profile, with a minimal set of modules enabled.
 * - For functional tests that do not test web output, define a class that
 *   extends \Drupal\simpletest\KernelTestBase. This class is much faster
 *   than WebTestBase, because instead of making a full install of Drupal, it
 *   uses an in-memory pseudo-installation (similar to what the installer and
 *   update scripts use). To use this test class, you will need to create the
 *   database tables you need and install needed modules manually.
 * - The namespace must be a subspace/subdirectory of \Drupal\yourmodule\Tests,
 *   where yourmodule is your module's machine name.
 * - The test class file must be named and placed under the yourmodule/src/Tests
 *   directory, according to the PSR-4 standard.
 * - Your test class needs a getInfo() method, which gives information about
 *   the test.
 * - You may also override the default setUp() method, which can set be used to
 *   set up content types and similar procedures.
 * - In some cases, you may need to write a test module to support your test;
 *   put such modules under the yourmodule/tests/modules directory.
 * - Methods in your test class whose names start with 'test', and which have
 *   no arguments, are the actual test cases. Each one should test a logical
 *   subset of the functionality, and each one runs in a new, isolated test
 *   environment, so it can only rely on the setUp() method, not what has
 *   been set up by other test methods.
 * For more details, see:
 * - https://drupal.org/simpletest for full documentation on how to write
 *   functional tests for Drupal.
 * - @link oo_conventions Object-oriented programming topic @endlink for more
 *   on PSR-4, namespaces, and where to place classes.
 *
 * @section running Running tests
 * You can run both Simpletest and PHPUnit tests by enabling the core Testing
 * module (core/modules/simpletest). Once that module is enabled, tests can be
 * run usin the core/scripts/run-tests.sh script, using
 * @link https://drupal.org/project/drush Drush @endlink, or from the Testing
 * module user interface.
 *
 * PHPUnit tests can also be run from the command line, using the PHPUnit
 * framework. See https://drupal.org/node/2116263 for more information.
 * @}
 */

/**
 * @defgroup info_types Information types
 * @{
 * Types of information in Drupal.
 *
 * Drupal has several distinct types of information, each with its own methods
 * for storage and retrieval:
 * - Content: Information meant to be displayed on your site: articles, basic
 *   pages, images, files, custom blocks, etc. Content is stored and accessed
 *   using @link entity_api Entities @endlink.
 * - Session: Information about individual users' interactions with the site,
 *   such as whether they are logged in. This is really "state" information, but
 *   it is not stored the same way so it's a separate type here. Session
 *   information is managed via the session_manager service in Drupal, which
 *   implements \Drupal\Core\Session\SessionManagerInterface. See the
 *   @link container Services topic @endlink for more information about
 *   services.
 * - State: Information of a temporary nature, generally machine-generated and
 *   not human-edited, about the current state of your site. Examples: the time
 *   when Cron was last run, whether node access permissions need rebuilding,
 *   etc. See @link state_api the State API topic @endlink for more information.
 * - Configuration: Information about your site that is generally (or at least
 *   can be) human-edited, but is not Content, and is meant to be relatively
 *   permanent. Examples: the name of your site, the content types and views
 *   you have defined, etc. See
 *   @link config_api the Configuration API topic @endlink for more information.
 *
 * @see cache
 * @see i18n
 * @}
 */

/**
 * @defgroup extending Extending and altering Drupal
 * @{
 * Overview of add-ons and alteration methods for Drupal.
 *
 * Drupal's core behavior can be extended and altered via these three basic
 * types of add-ons:
 * - Themes: Themes alter the appearance of Drupal sites. They can include
 *   template files, which alter the HTML markup and other raw output of the
 *   site; CSS files, which alter the styling applied to the HTML; and
 *   JavaScript, Flash, images, and other files. For more information, see the
 *   @link theme_render Theme system and render API topic @endlink and
 *   https://drupal.org/theme-guide/8
 * - Modules: Modules add to or alter the behavior and functionality of Drupal,
 *   by using one or more of the methods listed below. For more information
 *   about creating modules, see https://drupal.org/developing/modules/8
 * - Installation profiles: Installation profiles can be used to
 *   create distributions, which are complete specific-purpose packages of
 *   Drupal including additional modules, themes, and data. For more
 *   information, see https://drupal.org/documentation/build/distributions.
 *
 * Here is a list of the ways that modules can alter or extend Drupal's core
 * behavior, or the behavior of other modules:
 * - Hooks: Specially-named functions that a module defines, which are
 *   discovered and called at specific times, usually to alter behavior or data.
 *   See the @link hooks Hooks topic @endlink for more information.
 * - Plugins: Classes that a module defines, which are discovered and
 *   instantiated at specific times to add functionality. See the
 *   @link plugin_api Plugin API topic @endlink for more information.
 * - Entities: Special plugins that define entity types for storing new types
 *   of content or configuration in Drupal. See the
 *   @link entity_api Entity API topic @endlink for more information.
 * - Services: Classes that perform basic operations within Drupal, such as
 *   accessing the database and sending email. See the
 *   @link container Dependency Injection Container and Services topic @endlink
 *   for more information.
 * - Routing: Providing or altering "routes", which are URLs that Drupal
 *   responds to, or altering routing behavior with event listener classes.
 *   See the @link menu Routing and menu topic @endlink for more information.
 * @}
 */

/**
 * @defgroup plugin_api Plugin API
 * @{
 * Using the Plugin API
 *
 * @section sec_overview Overview and terminology

 * The basic idea of plugins is to allow a particular module or subsystem of
 * Drupal to provide functionality in an extensible, object-oriented way. The
 * controlling module or subsystem defines the basic framework (interface) for
 * the functionality, and other modules can create plugins (implementing the
 * interface) with particular behaviors. The controlling module instantiates
 * existing plugins as needed, and calls methods to invoke their functionality.
 * Examples of functionality in Drupal Core that use plugins include: the block
 * system (block types are plugins), the entity/field system (entity types,
 * field types, field formatters, and field widgets are plugins), the image
 * manipulation system (image effects and image toolkits are plugins), and the
 * search system (search page types are plugins).
 *
 * Plugins are grouped into plugin types, each generally defined by an
 * interface. Each plugin type is managed by a plugin manager service, which
 * uses a plugin discovery method to discover provided plugins of that type and
 * instantiate them using a plugin factory.
 *
 * Some plugin types make use of the following concepts or components:
 * - Plugin derivatives: Allows a single plugin class to present itself as
 *   multiple plugins. Example: the Menu module provides a block for each
 *   defined menu via a block plugin derivative.
 * - Plugin mapping: Allows a plugin class to map a configuration string to an
 *   instance, and have the plugin automatically instantiated without writing
 *   additional code.
 * - Plugin bags: Provide a way to lazily instantiate a set of plugin
 *   instances from a single plugin definition.
 *
 * There are several things a module developer may need to do with plugins:
 * - Define a completely new plugin type: see @ref sec_define below.
 * - Create a plugin of an existing plugin type: see @ref sec_create below.
 * - Perform tasks that involve plugins: see @ref sec_use below.
 *
 * See https://drupal.org/developing/api/8/plugins for more detailed
 * documentation on the plugin system. There are also topics for a few
 * of the many existing types of plugins:
 * - @link block_api Block API @endlink
 * - @link entity_api Entity API @endlink
 * - @link field Various types of field-related plugins @endlink
 * - @link views_plugins Views plugins @endlink (has links to topics covering
 *   various specific types of Views plugins).
 * - @link search Search page plugins @endlink
 *
 * @section sec_define Defining a new plugin type
 * To define a new plugin type:
 * - Define an interface for the plugin. This describes the common set of
 *   behavior, and the methods you will call on each plugin class that is
 *   instantiated. Usually this interface will extend one or more of the
 *   following interfaces:
 *   - \Drupal\Component\Plugin\PluginInspectionInterface
 *   - \Drupal\Component\Plugin\ConfigurablePluginInterface
 *   - \Drupal\Component\Plugin\ContextAwarePluginInterface
 *   - \Drupal\Core\Plugin\PluginFormInterface
 *   - \Drupal\Core\Executable\ExecutableInterface
 * - (optional) Create a base class that provides a partial implementation of
 *   the interface, for the convenience of developers wishing to create plugins
 *   of your type. The base class usually extends
 *   \Drupal\Core\Plugin\PluginBase, or one of the base classes that extends
 *   this class.
 * - Choose a method for plugin discovery, and define classes as necessary.
 *   See @ref sub_discovery below.
 * - Create a plugin manager/factory class and service, which will discover and
 *   instantiate plugins. See @ref sub_manager below.
 * - Use the plugin manager to instantiate plugins. Call methods on your plugin
 *   interface to perform the tasks of your plugin type.
 * - (optional) If appropriate, define a plugin bag. See @ref sub_bag below
 *   for more information.
 *
 * @subsection sub_discovery Plugin discovery
 * Plugin discovery is the process your plugin manager uses to discover the
 * individual plugins of your type that have been defined by your module and
 * other modules. Plugin discovery methods are classes that implement
 * \Drupal\Component\Plugin\Discovery\DiscoveryInterface. Most plugin types use
 * one of the following discovery mechanisms:
 * - Annotation: Plugin classes are annotated and placed in a defined namespace
 *   subdirectory. Most Drupal Core plugins use this method of discovery.
 * - Hook: Plugin modules need to implement a hook to tell the manager about
 *   their plugins.
 * - YAML: Plugins are listd in YAML files. Drupal Core uses this method for
 *   discovering local tasks and local actions. This is mainly useful if all
 *   plugins use the same class, so it is kind of like a global derivative.
 * - Static: Plugin classes are registered within the plugin manager class
 *   itself. Static discovery is only useful if modules cannot define new
 *   plugins of this type (if the list of available plugins is static).
 *
 * It is also possible to define your own custom discovery mechanism or mix
 * methods together. And there are many more details, such as annotation
 * decorators, that apply to some of the discovery methods. See
 * https://drupal.org/developing/api/8/plugins for more details.
 *
 * The remainder of this documentation will assume Annotation-based discovery,
 * since this is the most common method.
 *
 * @subsection sub_manager Defining a plugin manager class and service
 * To define an annotation-based plugin manager:
 * - Choose a namespace subdirectory for your plugin. For example, search page
 *   plugins go in directory Plugin/Search under the module namespace.
 * - Define an annotation class for your plugin type. This class should extend
 *   \Drupal\Component\Annotation\Plugin, and for most plugin types, it should
 *   contain member variables corresponding to the annotations plugins will
 *   need to provide. All plugins have at least $id: a unique string
 *   identifier.
 * - Define an alter hook for altering the discovered plugin definitions. You
 *   should document the hook in a *.api.php file.
 * - Define a plugin manager class. This class should implement
 *   \Drupal\Component\Plugin\PluginManagerInterface; most plugin managers do
 *   this by extending \Drupal\Core\Plugin\DefaultPluginManager. If you do
 *   extend the default plugin manager, the only method you will probably need
 *   to define is the class constructor, which will need to call the parent
 *   constructor to provide information about the annotation class and plugin
 *   namespace for discovery, set up the alter hook, and possibly set up
 *   caching. See classes that extend DefaultPluginManager for examples.
 * - Define a service for your plugin manager. See the
 *   @link container Services topic for more information. @endlink Your service
 *   definition should look something like this, referencing your manager
 *   class and the parent (default) plugin manager service to inherit
 *   constructor arguments:
 *   @code
 *   plugin.manager.mymodule:
 *     class: Drupal\mymodule\MyPluginManager
 *     parent: default_plugin_manager
 *   @endcode
 * - If your plugin is configurable, you will also need to define the
 *   configuration schema and possibly a configuration entity type. See the
 *   @link config_api Configuration API topic @endlink for more information.
 *
 * @subsection sub_bag Defining a plugin bag
 * Some configurable plugin types allow administrators to create zero or more
 * instances of each plugin, each with its own configuration. For example,
 * a single block plugin can be configured several times, to display in
 * different regions of a theme, with different visibility settings, a
 * different title, or other plugin-specific settings. To make this possible,
 * a plugin type can make use of what's known as a plugin bag.
 *
 * A plugin bag is a class that extends \Drupal\Component\Plugin\PluginBag or
 * one of its subclasses; there are several examples in Drupal Core. If your
 * plugin type uses a plugin bag, it will usually also have a configuration
 * entity, and the entity class should implement
 * \Drupal\Core\Entity\EntityWithPluginBagsInterface. Again,
 * there are several examples in Drupal Core; see also the
 * @link config_api Configuration API topic @endlink for more information about
 * configuration entities.
 *
 * @section sec_create Creating a plugin of an existing type
 * Assuming the plugin type uses annotation-based discovery, in order to create
 * a plugin of an existing type, you will be creating a class. This class must:
 * - Implement the plugin interface, so that it has the required methods
 *   defined. Usually, you'll want to extend the plugin base class, if one has
 *   been provided.
 * - Have the right annotation in its documentation header. See the
 *   @link annotation Annotation topic @endlink for more information about
 *   annotation.
 * - Be in the right plugin namespace, in order to be discovered.
 * Often, the easiest way to make sure this happens is to find an existing
 * example of a working plugin class of the desired type, and copy it into your
 * module as a starting point.
 *
 * You can also create a plugin derivative, which allows your plugin class
 * to present itself to the user interface as multiple plugins. To do this,
 * in addition to the plugin class, you'll need to create a separate plugin
 * derivative class implementing
 * \Drupal\Component\Plugin\Derivative\DerivativeInterface. The classes
 * \Drupal\system\Plugin\Block\SystemMenuBlock (plugin class) and
 * \Drupal\system\Plugin\Derivative\SystemMenuBlock (derivative class) are a
 * good example to look at.
 *
 * @sec sec_use Performing tasks involving plugins
 * Here are the steps to follow to perform a task that involves plugins:
 * - Locate the machine name of the plugin manager service, and instantiate the
 *   service. See the @link container Services topic @endlink for more
 *   information on how to do this.
 * - On the plugin manager class, use methods like getDefinition(),
 *   getDefinitions(), or other methods specific to particular plugin managers
 *   to retrieve information about either specific plugins or the entire list of
 *   defined plugins.
 * - Call the createInstance() method on the plugin manager to instantiate
 *   individual plugin objects.
 * - Call methods on the plugin objects to perform the desired tasks.
 *
 * @see annotation
 * @}
 */

/**
 * @defgroup oo_conventions Objected-oriented programming conventions
 * @{
 * PSR-4, namespaces, class naming, and other conventions.
 *
 * A lot of the PHP code in Drupal is object oriented (OO), making use of
 * @link http://php.net/manual/language.oop5.php PHP classes, interfaces, and traits @endlink
 * (which are loosely referred to as "classes" in the rest of this topic). The
 * following conventions and standards apply to this version of Drupal:
 * - Each class must be in its own file.
 * - Classes must be namespaced. If a module defines a class, the namespace
 *   must start with \Drupal\module_name. If it is defined by Drupal Core for
 *   use across many modules, the namespace should be \Drupal\Core or
 *   \Drupal\Component, with the exception of the global class \Drupal. See
 *   https://www.drupal.org/node/1353118 for more about namespaces.
 * - In order for the PSR-4-based class auto-loader to find the class, it must
 *   be located in a directory corresponding to the namespace. For
 *   module-defined classes, if the namespace is \Drupal\module_name\foo\bar,
 *   then the class goes under the main module directory in directory
 *   src/foo/bar. For Drupal-wide classes, if the namespace is
 *   \Drupal\Core\foo\bar, then it goes in directory
 *   core/lib/Drupal/Core/foo/bar. See https://www.drupal.org/node/2156625 for
 *   more information about PSR-4.
 * - Some classes have annotations added to their documentation headers. See
 *   the @link annotation Annotation topic @endlink for more information.
 * - Standard plugin discovery requires particular namespaces and annotation
 *   for most plugin classes. See the
 *   @link plugin_api Plugin API topic @endlink for more information.
 * - There are project-wide coding standards for OO code, including naming:
 *   https://drupal.org/node/608152
 * - Documentation standards for classes are covered on:
 *   https://www.drupal.org/coding-standards/docs#classes
 * @}
 */

/**
 * @defgroup best_practices Best practices for developers
 * @{
 * Overview of standards and best practices for developers
 *
 * Ideally, all code that is included in Drupal Core and contributed modules,
 * themes, and distributions will be secure, internationalized, maintainable,
 * and efficient. In order to facilitate this, the Drupal community has
 * developed a set of guidelines and standards for developers to follow. Most of
 * these standards can be found under
 * @link https://drupal.org/developing/best-practices Best practices on Drupal.org @endlink
 *
 * Standards and best practices that developers should be aware of include:
 * - Security: https://drupal.org/writing-secure-code and the
 *   @link sanitization Sanitization functions topic @endlink
 * - Coding standards: https://drupal.org/coding-standards
 *   and https://drupal.org/coding-standards/docs
 * - Accessibility: https://drupal.org/node/1637990 (modules) and
 *   https://drupal.org/node/464472 (themes)
 * - Usability: https://drupal.org/ui-standards
 * - Internationalization: @link i18n Internationalization topic @endlink
 * - Automated testing: @link testing Automated tests topic @endlink
 * @}
 */

/**
 * @defgroup utility Utility classes and functions
 * @{
 * Overview of utility classes and functions for developers.
 *
 * Drupal provides developers with a variety of utility functions that make it
 * easier and more efficient to perform tasks that are either really common,
 * tedious, or difficult. Utility functions help to reduce code duplication and
 * should be used in place of one-off code whenever possible.
 *
 * @see common.inc
 * @see file
 * @see format
 * @see mail.inc
 * @see php_wrappers
 * @see sanitization
 * @see transliteration
 * @see validation
 * @}
 */

/**
 * @defgroup hooks Hooks
 * @{
 * Define functions that alter the behavior of Drupal core.
 *
 * One way for modules to alter the core behavior of Drupal (or another module)
 * is to use hooks. Hooks are specially-named functions that a module defines
 * (this is known as "implementing the hook"), which are discovered and called
 * at specific times to alter or add to the base behavior or data (this is
 * known as "invoking the hook"). Each hook has a name (example:
 * hook_batch_alter()), a defined set of parameters, and a defined return value.
 * Your modules can implement hooks that are defined by Drupal core or other
 * modules that they interact with. Your modules can also define their own
 * hooks, in order to let other modules interact with them.
 *
 * To implement a hook:
 * - Locate the documentation for the hook. Hooks are documented in *.api.php
 *   files, by defining functions whose name starts with "hook_" (these
 *   files and their functions are never loaded by Drupal -- they exist solely
 *   for documentation). The function should have a documentation header, as
 *   well as a sample function body. For example, in the core file
 *   system.api.php, you can find hooks such as hook_batch_alter(). Also, if
 *   you are viewing this documentation on an API reference site, the Core
 *   hooks will be listed in this topic.
 * - Copy the function to your module's .module file.
 * - Change the name of the function, substituting your module's short name
 *   (name of the module's directory, and .info.yml file without the extension)
 *   for the "hook" part of the sample function name. For instance, to implemnt
 *   hook_batch_alter(), you would rename it to my_module_batch_alter().
 * - Edit the documentation for the function (normally, your implementation
 *   should just have one line saying "Implements hook_batch_alter().").
 * - Edit the body of the function, substituting in what you need your module
 *   to do.
 *
 * To define a hook:
 * - Choose a unique name for your hook. It should start with "hook_", followed
 *   by your module's short name.
 * - Provide documentation in a *.api.php file in your module's main
 *   directory. See the "implementing" section above for details of what this
 *   should contain (parameters, return value, and sample function body).
 * - Invoke the hook in your module's code.
 *
 * To invoke a hook, use methods on
 * \Drupal\Core\Extension\ModuleHandlerInterface such as alter(), invoke(),
 * and invokeAll(). You can obtain a module handler by calling
 * \Drupal::moduleHandler(), or getting the 'module_handler' service on an
 * injected container.
 *
 * @see extending
 * @see themeable
 * @see callbacks
 * @see \Drupal\Core\Extension\ModuleHandlerInterface
 * @see \Drupal::moduleHandler()
 *
 * @}
 */

/**
 * @defgroup callbacks Callbacks
 * @{
 * Callback function signatures.
 *
 * Drupal's API sometimes uses callback functions to allow you to define how
 * some type of processing happens. A callback is a function with a defined
 * signature, which you define in a module. Then you pass the function name as
 * a parameter to a Drupal API function or return it as part of a hook
 * implementation return value, and your function is called at an appropriate
 * time. For instance, when setting up batch processing you might need to
 * provide a callback function for each processing step and/or a callback for
 * when processing is finished; you would do that by defining these functions
 * and passing their names into the batch setup function.
 *
 * Callback function signatures, like hook definitions, are described by
 * creating and documenting dummy functions in a *.api.php file; normally, the
 * dummy callback function's name should start with "callback_", and you should
 * document the parameters and return value and provide a sample function body.
 * Then your API documentation can refer to this callback function in its
 * documentation. A user of your API can usually name their callback function
 * anything they want, although a standard name would be to replace "callback_"
 * with the module name.
 *
 * @see hooks
 * @see themeable
 *
 * @}
 */

/**
 * @defgroup form_api Form generation
 * @{
 * Describes how to generate and manipulate forms and process form submissions.
 *
 * Drupal provides a Form API in order to achieve consistency in its form
 * processing and presentation, while simplifying code and reducing the amount
 * of HTML that must be explicitly generated by a module.
 *
 * @section generating_forms Creating forms
 * Forms are defined as classes that implement the
 * \Drupal\Core\Form\FormInterface and are built using the
 * \Drupal\Core\Form\FormBuilder class. Drupal provides a couple of utility
 * classes that can be extended as a starting point for most basic forms, the
 * most commonly used of which is \Drupal\Core\Form\FormBase. FormBuilder
 * handles the low level processing of forms such as rendering the necessary
 * HTML, initial processing of incoming $_POST data, and delegating to your
 * implementation of FormInterface for validation and processing of submitted
 * data.
 *
 * Here is an example of a Form class:
 * @code
 * namespace Drupal\mymodule\Form;
 *
 * use Drupal\Core\Form\FormBase;
 *
 * class ExampleForm extends FormBase {
 *   public function getFormId() {
 *     // Unique ID of the form.
 *     return 'example_form';
 *   }
 *
 *   public function buildForm(array $form, array &$form_state) {
 *     // Create a $form API array.
 *     $form['phone_number'] = array(
 *       '#type' => 'tel',
 *       '#title' => $this->t('Your phone number')
 *     );
 *     return $form;
 *   }
 *
 *   public function validateForm(array &$form, array &$form_state) {
 *     // Validate submitted form data.
 *   }
 *
 *   public function submitForm(array &$form, array &$form_state) {
 *     // Handle submitted form data.
 *   }
 * }
 * @endcode
 *
 * @section retrieving_forms Retrieving and displaying forms
 * \Drupal::formBuilder()->getForm() should be used to handle retrieving,
 * processing, and displaying a rendered HTML form. Given the ExampleForm
 * defined above,
 * \Drupal::formBuilder()->getForm('Drupal\mymodule\Form\ExampleForm') would
 * return the rendered HTML of the form defined by ExampleForm::buildForm(), or
 * call the validateForm() and submitForm(), methods depending on the current
 * processing state.
 *
 * The argument to \Drupal::formBuilder()->getForm() is the name of a class that
 * implements FormBuilderInterface. Any additional arguments passed to the
 * getForm() method will be passed along as additional arguments to the
 * ExampleForm::buildForm() method.
 *
 * For example:
 * @code
 * $extra = '612-123-4567';
 * $form = \Drupal::formBuilder()->getForm('Drupal\mymodule\Form\ExampleForm', $extra);
 * ...
 * public function buildForm(array $form, array &$form_state, $extra = NULL)
 *   $form['phone_number'] = array(
 *     '#type' => 'tel',
 *     '#title' => $this->t('Your phone number'),
 *     '#value' => $extra,
 *   );
 *   return $form;
 * }
 * @endcode
 *
 * Alternatively, forms can be built directly via the routing system which will
 * take care of calling \Drupal::formBuilder()->getForm(). The following example
 * demonstrates the use of a routing.yml file to display a form at the the
 * given route.
 *
 * @code
 * example.form:
 *   path: '/example-form'
 *   defaults:
 *     _title: 'Example form'
 *     _form: '\Drupal\mymodule\Form\ExampleForm'
 * @endcode
 *
 * The $form argument to form-related functions is a structured array containing
 * the elements and properties of the form. For information on the array
 * components and format, and more detailed explanations of the Form API
 * workflow, see the
 * @link forms_api_reference.html Form API reference @endlink
 * and the
 * @link https://drupal.org/node/2117411 Form API documentation section. @endlink
 * In addition, there is a set of Form API tutorials in
 * @link form_example_tutorial.inc the Form Example Tutorial @endlink which
 * provide basics all the way up through multistep forms.
 *
 * In the form builder, validation, submission, and other form methods,
 * $form_state is the primary influence on the processing of the form and is
 * passed by reference to most methods, so they can use it to communicate with
 * the form system and each other.
 *
 * See \Drupal\Core\Form\FormBuilder::buildForm() for documentation of
 * $form_state keys.
 */

/**
 * @} End of "defgroup form_api".
 */

/**
 * @defgroup queue Queue operations
 * @{
 * Queue items to allow later processing.
 *
 * The queue system allows placing items in a queue and processing them later.
 * The system tries to ensure that only one consumer can process an item.
 *
 * Before a queue can be used it needs to be created by
 * Drupal\Core\Queue\QueueInterface::createQueue().
 *
 * Items can be added to the queue by passing an arbitrary data object to
 * Drupal\Core\Queue\QueueInterface::createItem().
 *
 * To process an item, call Drupal\Core\Queue\QueueInterface::claimItem() and
 * specify how long you want to have a lease for working on that item.
 * When finished processing, the item needs to be deleted by calling
 * Drupal\Core\Queue\QueueInterface::deleteItem(). If the consumer dies, the
 * item will be made available again by the Drupal\Core\Queue\QueueInterface
 * implementation once the lease expires. Another consumer will then be able to
 * receive it when calling Drupal\Core\Queue\QueueInterface::claimItem().
 * Due to this, the processing code should be aware that an item might be handed
 * over for processing more than once.
 *
 * The $item object used by the Drupal\Core\Queue\QueueInterface can contain
 * arbitrary metadata depending on the implementation. Systems using the
 * interface should only rely on the data property which will contain the
 * information passed to Drupal\Core\Queue\QueueInterface::createItem().
 * The full queue item returned by Drupal\Core\Queue\QueueInterface::claimItem()
 * needs to be passed to Drupal\Core\Queue\QueueInterface::deleteItem() once
 * processing is completed.
 *
 * There are two kinds of queue backends available: reliable, which preserves
 * the order of messages and guarantees that every item will be executed at
 * least once. The non-reliable kind only does a best effort to preserve order
 * in messages and to execute them at least once but there is a small chance
 * that some items get lost. For example, some distributed back-ends like
 * Amazon SQS will be managing jobs for a large set of producers and consumers
 * where a strict FIFO ordering will likely not be preserved. Another example
 * would be an in-memory queue backend which might lose items if it crashes.
 * However, such a backend would be able to deal with significantly more writes
 * than a reliable queue and for many tasks this is more important. See
 * aggregator_cron() for an example of how to effectively utilize a
 * non-reliable queue. Another example is doing Twitter statistics -- the small
 * possibility of losing a few items is insignificant next to power of the
 * queue being able to keep up with writes. As described in the processing
 * section, regardless of the queue being reliable or not, the processing code
 * should be aware that an item might be handed over for processing more than
 * once (because the processing code might time out before it finishes).
 */

/**
 * @} End of "defgroup queue".
 */

/**
 * @addtogroup hooks
 * @{
 */

/**
 * Alter display variant plugin definitions.
 *
 * @param array $definitions
 *   The array of display variant definitions, keyed by plugin ID.
 *
 * @see \Drupal\Core\Display\VariantManager
 * @see \Drupal\Core\Display\Annotation\DisplayVariant
 */
function hook_display_variant_plugin_alter(array &$definitions) {
  $definitions['full_page']['admin_label'] = t('Block layout');
}

/**
 * @} End of "addtogroup hooks".
 */

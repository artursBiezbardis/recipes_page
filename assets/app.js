const $ = require('jquery');
//import moment from 'moment';
/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.css';


/*import 'jquery.scrollto';

// Only using sortable widget from jQuery UI library
import 'jquery-ui/ui/widget';
import 'jquery-ui/ui/widgets/sortable';
import 'jquery-form';*/
// start the Stimulus application
import './bootstrap';

//import './js/sonata'


global.$ = $;
global.jQuery = $;

// Create global moment variable to be used by the locale script.
// It expects moment to be available on the global scope
// in order to define the requested locale translations
//global.moment = moment;

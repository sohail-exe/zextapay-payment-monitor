import { render } from '@wordpress/element';
import App from './components/App';
import './index.css';

window.addEventListener( 'DOMContentLoaded', () => {
    const container = document.getElementById( 'zextapay-react-dashboard' );
    if ( container ) {
        render( <App />, container );
    }
} );
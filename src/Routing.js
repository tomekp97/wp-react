import React, {Component} from 'react';
import {BrowserRouter, Route, Link} from 'react-router-dom';

import App from './App';
import MovieClips from './components/pages/MovieClips';

class Routing extends Component {
    render() {
        return(
            <BrowserRouter>
                <nav className="main-nav">
                    <li>
                        <Link to="/">Home</Link>
                    </li>

                    <Route exact path="/" component={App} />
                    <Route path="/movie-clips" component={MovieClips} />
                </nav>
            </BrowserRouter>
        )
    }
}
export default Routing;
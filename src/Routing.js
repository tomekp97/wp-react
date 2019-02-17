import React, {Component} from 'react';
import {BrowserRouter, Route, Link} from 'react-router-dom';

import App from './App';
import FrontPage from './components/pages/FrontPage';
import PostsIndex from './components/pages/PostsIndex';
import MovieClips from './components/pages/MovieClips';
import Default from './components/pages/Default';
import About from './components/pages/About';

const templates = {
    template_about: About,
    front_page: FrontPage,
    posts_index: PostsIndex
}

class Routing extends Component {
    constructor() {
        super();

        this.state = {
            pages: []
        }
    }

    // Update state with site's main menu
    componentDidMount() {
        let dataUrl = "http://wp-react.local/wp-json/menus/main-menu";

        fetch(dataUrl)
          .then(response => response.json())
          .then(results => {
              this.setState({
                  pages: results
              })
          })
    }

    renderMainMenu = () => {
        return(
            this.state.pages.map( (page, index) =>
                <li className="nav-item" key={index}>
                    <Link to={page.url_path[0]}>
                        {page.title}
                    </Link>
                </li>
            )
        )
    }

    generateRoutes = () => {
        let pageRoutes = [];

        this.state.pages.map( (page, index) => {
            let singleRoute = {};
            let useComponent = Default;

            if (page.is_special_template) {
                if (templates[page.is_special_template]) {
                    useComponent = templates[page.is_special_template];
                }
            }

            if (templates[page.page_template]) {
                useComponent = templates[page.page_template];
            }

            singleRoute.path = page.url_path[0];
            singleRoute.component = useComponent;

            pageRoutes.push(singleRoute);
        })

        console.log(pageRoutes);
        return(
            pageRoutes.map( (route, index) =>
                <Route
                    exact
                    key={index}
                    path={route.path}
                    component={route.component} />
            )
        )
    }

    render() {
        let mainMenu = this.renderMainMenu();
        let routes = this.generateRoutes();

        return(
            <BrowserRouter>
                <nav className="main-nav">
                    {mainMenu}
                    {routes}
                    {/* <Route exact path="/" component={App} />
                    <Route path="/movie-clips" component={MovieClips} /> */}
                </nav>
            </BrowserRouter>
        )
    }
}

export default Routing;
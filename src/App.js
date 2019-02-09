import React, { Component } from 'react';

import Header from './components/Header';

class App extends Component {
    constructor() {
        super();

        this.state = {
            movies: []
        }
    }

    // Use this method to make external API calls
    componentDidMount() {
        let dataUrl = "http://wp-react.local/wp-json/wp/v2/movie";

        fetch(dataUrl)
          .then(response => response.json())
          .then(results => {
              this.setState({
                  movies: results
              })
          })
    }

    renderMovies = () => {
        return (
            this.state.movies.map( (movie, index) =>
                <article className="movie" key={index}>
                    <h3>{movie.title.rendered}<sup>{movie.acf.genre}</sup></h3>
                    <h4>{movie.acf.director}</h4>
                    <p>{movie.acf.date_of_release}</p>
                </article>
            )
        )
    }

    render() {
        let movies = this.renderMovies();

        return(
            <main>
                <Header/>
                
                <h2>Movies</h2>
                {movies}
            </main>
        )
    }
}

export default App;
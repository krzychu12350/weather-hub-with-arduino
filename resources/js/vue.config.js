module.exports = {
    devServer: {
        //po wejsciu przez ta sciezke dziala
        proxy: 'http://localhost:8000/',
        changeOrigin: true,
        port: 8081
    }
}

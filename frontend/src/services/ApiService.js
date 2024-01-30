import axios from "axios";

class ApiService {
  /**
   * @param {String} baseUrl
   */
  constructor(baseUrl) {
    this.baseUrl = baseUrl.replace(/\/$/, '');
  }

  /**
   * @param {String} path
   *
   * @returns {string}
   */
  getFullUrl(path) {
    if (path[0] === '/') {
      path = path.slice(1)
    }

    return this.baseUrl + '/' + path;
  }

  /**
   * @param {String} path
   * @param {Object|Array} query
   *
   * @returns {Promise}
   */
  get(path, query = {}) {
    return axios.get(this.getFullUrl(path), {params: query})
      .then(r => r.data)
  }

  /**
   * @param {String} path
   * @param {Object|Array} body
   *
   * @returns {Promise}
   */
  post(path, body = {}) {
    return axios.post(this.getFullUrl(path), body)
      .then(r => r.data)
  }
}

export default ApiService;

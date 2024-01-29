import ApiService from "@/services/ApiService.js";
import Subscriber from "@/entities/Subscriber.js";

class SubscribersRepository {
  constructor() {
    this.api = new ApiService(window.config.API_URL)
  }

  /**
   * @param {int} page
   * @param {int} limit
   * @param {Array} filters
   *
   * @returns {Promise}
   */
  getPaginated(page, limit, filters = {}) {
    filters['page'] = page > 1 ? page : 1;
    filters['limit'] = limit > 0 ? limit: 10;

    return this.api.get('/subscribers', filters)
      .then(subscribers => {
        for (let i in subscribers.data) {
          if (subscribers.data.hasOwnProperty(i)) {
            subscribers.data[i] = new Subscriber(subscribers.data[i]);
          }
        }

        return subscribers;
      })
  }

  /**
   * @param {Object} data
   *
   * @returns {Promise}
   */
  store(data) {
    return this.api.post('/subscribers', data)
  }
}

export default SubscribersRepository = new SubscribersRepository;

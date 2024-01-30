export default class Subscriber {
  static UNSUBSCRIBED = 0;
  static SUBSCRIBED = 1;
  static BLOCKED = 2;

  /**
   * @param {Object} data
   */
  constructor(data) {
    this.firstName = data.first_name;
    this.lastName = data.last_name;
    this.email = data.email;
    this.status = data.status;
    this.statusLabel = data.status_label;
    this.statusColor = data.status_color;
    this.subscribedAt = data.subscribed_at;
  }

  /**
   * @returns {Object}
   */
  static getPossibleStatus() {
    let status = {};

    status[this.UNSUBSCRIBED] = {label: 'Unsubscribed', value: this.UNSUBSCRIBED, color: '#ffff00'};
    status[this.SUBSCRIBED] = {label: 'Subscribed', value: this.SUBSCRIBED, color: '#00ff00'};
    status[this.BLOCKED] = {label: 'Blocked', value: this.BLOCKED, color: '#ff0000'}

    return status;
  }

  /**
   * @returns {string}
   */
  getName() {
    return this.firstName + ' ' + this.lastName;
  }

  /**
   * @returns {string}
   */
  getEmail() {
    return this.email;
  }

  /**
   * @returns {string}
   */
  getStatus() {
    return this.status;
  }

  /**
   * @returns {string}
   */
  getStatusLabel() {
    return this.statusLabel;
  }

  /**
   * @returns {string}
   */
  getStatsColor() {
    return this.statusColor;
  }

  /**
   * @returns {string}
   */
  getSubscribedAt() {
    return this.subscribedAt;
  }
}

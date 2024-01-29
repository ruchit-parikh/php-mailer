<script src="./app.js"></script>

<template>
  <header>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
      <div class="container">
        <router-link to="/" class="navbar-brand">Mailer</router-link>
        <mailer-button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar" aria-controls="navbar" aria-expanded="false" aria-label="Open Menu">
          <span class="navbar-toggler-icon"></span>
        </mailer-button>
        <div class="collapse navbar-collapse" id="navbar">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
              <router-link class="nav-link" aria-current="page" to="/">Subscribers</router-link>
            </li>
          </ul>
          <router-link to="/create" class="btn btn-success">Add Subscriber</router-link>
        </div>
      </div>
    </nav>
  </header>

  <main>
    <div class="container">
      <div v-if="loading" style="height: 100vh;">
        <mailer-loader />
      </div>

      <div class="my-3" v-else>
        <alert
          v-if="$route.path === '/'"
          v-for="notification in persistentNotifications"
          :type="notification.type"
          :message="notification.message"
        />
        <alert
            v-else
            v-for="notification in temporaryNotifications"
            :type="notification.type"
            :message="notification.message"
        />

        <router-view />
      </div>
    </div>
  </main>
</template>

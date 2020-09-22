Nova.booting((Vue, router, store) => {
  router.addRoutes([
    {
      name: 'visa-config',
      path: '/visa-config',
      component: require('./components/Tool'),
    },
  ])
})

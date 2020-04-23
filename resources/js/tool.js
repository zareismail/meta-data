Nova.booting((Vue, router, store) => {
  router.addRoutes([
    {
      name: 'amenity',
      path: '/amenity',
      component: require('./components/Tool'),
    },
  ])
})

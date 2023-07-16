import React from 'react'
import Path from './path'
import NoFoundController from '@/controllers/Error/NoFoundController'

const HomeController = React.lazy(() => import('@/controllers/Home/HomeController'))

export enum RouterAccess {
  ALL,
  AUTH,
  GUEST,
}

export interface Route {
  path: Path
  Component: React.ComponentType
  access: RouterAccess
}

export const NoFoundComponent = NoFoundController

const routes: Array<Route> = [
  {
    path: Path.HOME,
    Component: HomeController,
    access: RouterAccess.ALL,
  },
]

export default routes

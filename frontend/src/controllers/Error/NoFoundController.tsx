import { Error } from '@/components/Common/Router'
import React from 'react'

const NoFoundController: React.FC = (): JSX.Element => {
  return (
    <div>
      <Error code={404} message="Page not found" />
    </div>
  )
}

export default NoFoundController

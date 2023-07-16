import React from 'react'
import { BrowserRouter } from 'react-router-dom'

const App: React.FC<React.PropsWithChildren> = ({ children }): JSX.Element => {
  return <BrowserRouter>{children}</BrowserRouter>
}

export default App

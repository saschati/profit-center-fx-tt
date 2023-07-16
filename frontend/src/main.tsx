import React from 'react'
import ReactDOM from 'react-dom/client'
import './styles/index.scss'
import App from './components/Domain/Container/App'
import reportWebVitals from './utils/reportWebVitals'
import Layout from './components/Domain/Container/Layout/Main/Layout'
import { RouterList } from './components/Domain/Router'
import { AuthProvider } from './components/Domain/Container/Auth'

const root = ReactDOM.createRoot(document.getElementById('root') as HTMLElement)
root.render(
  <React.StrictMode>
    <App>
      <AuthProvider>
        <Layout>
          <RouterList />
        </Layout>
      </AuthProvider>
    </App>
  </React.StrictMode>
)

// If you want to start measuring performance in your app, pass a function
// to log results (for example: reportWebVitals(console.log))
// or send to an analytics endpoint. Learn more: https://bit.ly/CRA-vitals
reportWebVitals()

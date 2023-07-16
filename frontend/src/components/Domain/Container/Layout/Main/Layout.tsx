import React from 'react'
import styles from './Layout.module.scss'
import LayoutProvider from '../Provider/LayoutProvider'

const Layout: React.FC<React.PropsWithChildren> = ({ children }): JSX.Element => {
  return (
    <LayoutProvider>
      <div className={styles.layout}>
        <header className={styles.layout__header}>Header</header>
        <main className={styles.layout__content}>{children}</main>
        <footer className={styles.layout__footer}>Footer</footer>
      </div>
    </LayoutProvider>
  )
}

export default Layout

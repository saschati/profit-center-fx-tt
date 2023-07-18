import React from 'react'
import styles from './Scrollbar.module.scss'
import classNames from 'classnames/bind'

const cx = classNames.bind(styles)

export type ScrollbarProps = React.PropsWithChildren & {
  className?: string
}

const Scrollbar: React.FC<ScrollbarProps> = ({ children, className }): JSX.Element => {
  return <div className={cx('scrollbar', className)}>{children}</div>
}

export default Scrollbar

import React from 'react'
import { Title } from '@/UI/Text'
import styles from './Error.module.scss'
import classNames from 'classnames/bind'

const cx = classNames.bind(styles)

export type ErrorProps = {
  code: number
  message: string
}

const Error: React.FC<ErrorProps> = ({ code, message }): JSX.Element => {
  return (
    <div data-testid="error" className={cx('error')}>
      <Title position="center">Error: {code}</Title>
      <p className={cx('error__message')}>{message}</p>
    </div>
  )
}

export default Error

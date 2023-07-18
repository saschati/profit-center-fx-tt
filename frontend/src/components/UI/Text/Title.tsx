import React from 'react'
import styles from './Title.module.scss'
import classNames from 'classnames/bind'

const cx = classNames.bind(styles)

type TitleSize = 'default'
type TitlePosition = 'start' | 'center'

export type TitleProps = React.PropsWithChildren & {
  className?: string
  size?: TitleSize
  position?: TitlePosition
  as?: keyof JSX.IntrinsicElements | React.FC
}

const Title: React.FC<TitleProps> = ({
  children,
  className,
  size = 'default',
  position = 'default',
  as = 'h1',
}): JSX.Element => {
  const CustomTag = as

  return (
    <CustomTag
      data-testid="text-title"
      className={cx('title', `title_size_${size}`, `title_position_${position}`, className)}
    >
      {children}
    </CustomTag>
  )
}

export default Title

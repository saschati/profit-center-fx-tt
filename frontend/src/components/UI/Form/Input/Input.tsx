import React, { useImperativeHandle, useRef } from 'react'
import styles from './Input.module.scss'
import classNames from 'classnames/bind'

const cx = classNames.bind(styles)

type RIcon =
  | {
      ricon?: JSX.Element
      riconClassName?: never
    }
  | {
      ricon: JSX.Element
      riconClassName: string
    }

export type InputHandle = {
  focus: () => void
}

export type InputProps = JSX.IntrinsicElements['input'] &
  RIcon & {
    type: React.HTMLInputTypeAttribute
    ref?: React.Ref<HTMLInputElement> | null
    errorMessage?: string
  }

const Input = React.forwardRef<InputHandle, InputProps>(
  ({ type, className, ricon, riconClassName, errorMessage, ...rest }, ref): JSX.Element => {
    const inputRef = useRef<HTMLInputElement>(null)

    const inputHandler = () => ({
      focus: () => inputRef.current?.focus(),
    })

    useImperativeHandle(ref, inputHandler, [])

    return (
      <div className={cx('input', className)}>
        <div className={cx('input__group')}>
          <input ref={inputRef} className={cx('input__handler')} type={type} {...rest} />
          {ricon && <div className={cx('input__ricon', riconClassName)}>{ricon}</div>}
        </div>
        {errorMessage && <div className={cx('input__error')}>{errorMessage}</div>}
      </div>
    )
  }
)

Input.displayName = 'Input'

export default Input

import React, { memo, useCallback } from 'react'
import styles from './Pagginate.module.scss'
import classNames from 'classnames/bind'
import ReactPaginate, { type ReactPaginateProps } from 'react-paginate'

const cx = classNames.bind(styles)

type ReactPaginatePropsRequired = Required<Pick<ReactPaginateProps, 'onPageChange'>>

export type PagginateProps = ReactPaginateProps & {
  onChange(page: number): void
  pageCount: number
  forcePage: number
}

const Pagginate: React.FC<PagginateProps> = ({ className, onChange, pageCount, forcePage, ...rest }): JSX.Element => {
  const handlerZero = useCallback(() => null, [])
  const handlerPageChange = useCallback<ReactPaginatePropsRequired['onPageChange']>(
    ({ selected }) => onChange(selected + 1),
    [onChange]
  )

  return (
    <ReactPaginate
      className={cx('pagginate', className)}
      pageCount={pageCount}
      pageRangeDisplayed={4}
      marginPagesDisplayed={2}
      onPageChange={handlerPageChange}
      forcePage={forcePage && forcePage - 1}
      renderOnZeroPageCount={handlerZero}
      disableInitialCallback={true}
      breakLabel="..."
      nextLabel=">"
      previousLabel="<"
      breakClassName={cx('pagginate__break')}
      breakLinkClassName={cx('pagginate__link')}
      pageClassName={cx('pagginate__item')}
      pageLinkClassName={cx('pagginate__link')}
      previousClassName={cx('pagginate__previous', 'pagginate__item')}
      previousLinkClassName={cx('pagginate__link')}
      nextClassName={cx('pagginate__next', 'pagginate__item')}
      nextLinkClassName={cx('pagginate__link')}
      activeClassName={cx('pagginate__item_type_active')}
      disabledClassName={cx('pagginate__item_type_disabled')}
      {...rest}
    />
  )
}

const PagginateMemo = memo(Pagginate)

export default PagginateMemo

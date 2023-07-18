import React, { useCallback, useState } from 'react'
import styles from './StockQuotes.module.scss'
import classNames from 'classnames/bind'
import Button from '@/UI/Button'
import PulsatingPreloader from '@/UI/Preloader/PulsatingPreloader'
import StockQuotesStatisticGrid from './StockQuotesStatisticGrid'
import useStockQuotesWS from '@/hooks/domain/stockQuotes/useStockQuotesWS'
import { Form, Formik } from 'formik'
import { FormikButton, FormikInput } from '@/Domain/Formik'
import Yup from '@/utils/yup'
import { v4 as uuidv4 } from 'uuid'
import collectStatistic from '@/app/model/stockQuotes/collectStatistic'
import { store } from '@/app/store/redux/store'
import { stockQuotesApi } from '@/app/store/redux/services/injects/stockQuotes'

const cx = classNames.bind(styles)

type StartValues = {
  count?: number
}

type SendStartData = {
  startDate: number
  endDate: number
  sessionId: string
}

const MIN_COUNT_FOR_START = 2

const initialValues: StartValues = {
  count: undefined,
}

const validateSchema = Yup.object().shape({
  count: Yup.number()
    .required("Кількість котировок обов'язкова для запуску.")
    .min(MIN_COUNT_FOR_START, `Мінімальна кількість "${MIN_COUNT_FOR_START}"`),
})

const calculateCollect = collectStatistic<SendStartData>((statistic, data) => {
  const postData = {
    ...statistic,
    ...data,
  }

  void store.dispatch(stockQuotesApi.endpoints.saveStatistics.initiate(postData))
})

const StockQuotes: React.FC = (): JSX.Element => {
  const [start, setStart] = useState(() => ({ isStart: false, count: 0, startData: 0, sessionId: '' }))
  const [isStatistic, setIsStatisric] = useState(false)

  useStockQuotesWS((data) => {
    calculateCollect(data.value, start.count, {
      startDate: start.startData,
      endDate: new Date().getTime(),
      sessionId: start.sessionId,
    })
  }, start.isStart)

  const handlerSubmit = useCallback((values: StartValues) => {
    setStart((prevState) => ({
      ...prevState,
      isStart: true,
      count: values.count as number,
      startData: new Date().getTime(),
      sessionId: uuidv4(),
    }))
  }, [])

  const handlerStatistic = () => setIsStatisric(!isStatistic)

  return (
    <div className={cx('stockQuotes')}>
      {!isStatistic && (
        <div className={cx('stockQuotes__runner')}>
          <div className={cx('stockQuotes__statisticBtn')}>
            <Button text="Статистика" onClick={handlerStatistic} />
          </div>
          {!start.isStart && (
            <Formik initialValues={initialValues} onSubmit={handlerSubmit} validationSchema={validateSchema}>
              <Form className={cx('stockQuotes__startGroup')}>
                <div className={cx('stockQuotes__input')}>
                  <FormikInput name="count" type="text" placeholder="Кількість котирувань" />
                </div>
                <div className={cx('stockQuotes__startBtn')}>
                  <FormikButton text="Старт" />
                </div>
              </Form>
            </Formik>
          )}
          {start.isStart && (
            <div className={cx('stockQuotes__preloader')}>
              <PulsatingPreloader size="big" />
            </div>
          )}
        </div>
      )}
      {isStatistic && (
        <div className={cx('stockQuotes__statistic')}>
          <StockQuotesStatisticGrid />
        </div>
      )}
    </div>
  )
}

export default StockQuotes

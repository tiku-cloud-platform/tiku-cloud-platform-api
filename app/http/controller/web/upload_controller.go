package web

import (
	"github.com/gin-gonic/gin"

	"tiku-cloud/app/global/consts"
	"tiku-cloud/app/global/variable"
	"tiku-cloud/app/service/upload_file"
	"tiku-cloud/app/utils/response"
)

type Upload struct {
}

// StartUpload 文件上传是一个独立模块，给任何业务返回文件上传后的存储路径即可。
// 开始上传
func (u *Upload) StartUpload(context *gin.Context) {
	savePath := variable.BasePath + variable.ConfigYml.GetString("FileUploadSetting.UploadFileSavePath")
	if r, finnalSavePath := upload_file.Upload(context, savePath); r == true {
		response.Success(context, consts.CurdStatusOkMsg, finnalSavePath)
	} else {
		response.Fail(context, consts.FilesUploadFailCode, consts.FilesUploadFailMsg, "")
	}
}

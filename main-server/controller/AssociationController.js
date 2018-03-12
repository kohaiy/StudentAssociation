const BaseController = require('./BaseController');
const AssociationService = require('../service/AssociationService');
const SessionService = require('../service/SessionService');

class AssociationController extends BaseController {
    static async createAssociation(ctx) {
        const token = ctx.header.authorization;
        let result = await SessionService.validateToken(token);
        if (result.status === 0) {
            const { name, city, description } = ctx.request.body;
            result = await AssociationService.createAssociation(result.data._id, name, city, description);
        }
        ctx.json(result);
    }

    static async getBySchool(ctx) {
        const schoolId = ctx.params.school;
        ctx.json(await AssociationService.getAssociationsBySchoolId(schoolId));
    }

    static async getById(ctx) {
        ctx.json(await AssociationService.getById(ctx.params.id, ctx.request.query));
    }
}

module.exports = AssociationController;